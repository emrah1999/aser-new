@servers(['web' => $user . '@' . $host])

@setup
echo 'here';
$repository = 'git@gitlab.com:CRBN/colibri-legacy/colibri-client-legacy.git';
$app_dir = isset($dir) ? $dir : '/var/www/app';
$releases_dir = $app_dir . '/releases';
$release = date('YmdHis');
$new_release_dir = $releases_dir .'/'. $release;
$branch = isset($branch) ? $branch : 'master';
@endsetup


@story('deploy', ['on' => 'web'])
deployment_start
deployment_links
deployment_composer
{{--	deployment_migrate--}}
deployment_finish
health_check
deployment_option_cleanup
@endstory

@story('deploy_cleanup')
deployment_start
deployment_links
deployment_composer
deployment_migrate
deployment_finish
health_check
deployment_cleanup
@endstory

@story('rollback')
deployment_rollback
health_check
@endstory

@task('deployment_start')
[ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
echo "Deployment release => {{ $release }} started! ( host => {{$host}} )"
git clone {{ $repository }} --branch={{ $branch }} --depth=1 -q {{ $new_release_dir }}
echo "Repository cloned"
@endtask

@task('deployment_links')
cd {{ $app_dir }}
rm -rf {{ $new_release_dir }}/storage
ln -s {{ $app_dir }}/storage {{ $new_release_dir }}/storage
echo "Storage directories set up"
ln -s {{ $app_dir }}/.env {{ $new_release_dir }}/.env
echo "Environment file set up"
@endtask

@task('deployment_composer')
echo "Installing composer depencencies..."
cd {{ $new_release_dir }}
composer install --no-interaction --quiet --no-dev --prefer-dist --optimize-autoloader
@endtask

@task('deployment_migrate')
php {{ $new_release_dir }}/artisan migrate --force --no-interaction
@endtask

@task('deployment_finish')
php {{ $new_release_dir }}/artisan queue:restart --quiet
echo "Queue restarted"
ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
php {{ $new_release_dir }}/artisan storage:link
echo "Deployment ({{ $release }}) finished"
@endtask

@task('deployment_cleanup')
cd {{ $app_dir }}
find . -maxdepth 1 -name "20*" | sort | head -n -4 | xargs rm -Rf
echo "Cleaned up old deployments"
@endtask

@task('deployment_option_cleanup')
cd {{ $app_dir }}
@if ( isset($cleanup) && $cleanup )
    find . -maxdepth 1 -name "20*" | sort | head -n -4 | xargs rm -Rf
    echo "Cleaned up old deployments"
@endif
@endtask


@task('health_check')
@if ( isset($healthUrl) )
    if [ "$(curl --write-out "%{http_code}\n" --silent --output /dev/null {{ $healthUrl }})" == "200" ]; then
    printf "\033[0;32mHealth check to {{ $healthUrl }} OK\033[0m\n"
    else
    printf "\033[1;31mHealth check to {{ $healthUrl }} FAILED\033[0m\n"
    fi
@else
    echo "No health check set"
@endif
@endtask


@task('deployment_rollback')
cd {{ $app_dir }}
ln -nfs {{ $app_dir }}/$(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1) {{ $app_dir }}/current
echo "Rolled back to $(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1)"
@endtask

{{--
@finished
	@slack($slack, '#deployments', "Deployment on {$server}: {$date} complete")
@endfinished
--}}


