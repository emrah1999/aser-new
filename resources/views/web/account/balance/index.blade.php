@extends('web.layouts.web')
@section('content')

    <div class="content" id="content">
        <section class="section section-profile-balances">
            <div class="container-lg">
                <div class="row">
                    @include("web.account.account_left_bar")
                    <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-7">
                        <div class="thumbnail thumbnail-profile-title-block d-flex justify-content-between align-items-center">
                            <h4 class="thumbnail-profile-title-block__title font-n-b">Balansım</h4>
                            <div class="d-flex justify-content-center align-items-center">
                                <p class="thumbnail-profile-title-block__desc">
                                    <span>Balansım :</span>
                                    <span class=font-n-b>{{Auth::user()->balance}} USD</span>
                                </p>
                                <button class="btn btn-blue thumbnail-profile-title-block__btn d-flex justify-content-center align-items-center font-n-b" type="button" data-bs-toggle="modal" data-bs-target="#modalProfileBalanceAdd">
                                    <img class="thumbnail-profile-title-block__btn-img" src="/web/images/content/other-plus-3.png" alt="Add">
                                    <span class="thumbnail-profile-title-block__btn-title d-none d-lg-block">Balansı artır</span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($logs as $log)
                                <div class="col-lg-6">
                                    <div class="thumbnail thumbnail-balances-transactions d-flex justify-content-between align-items-start">
                                        <div class="thumbnail-balances-transactions__caption">
                                            <h6 class="thumbnail-balances-transactions__title font-n-b">
                                                @switch($log->type)
                                                    @case('cart')
                                                        Kart
                                                        @break
                                                    @case('balance')
                                                        Balansdan
                                                        @break
                                                    @case('courier')
                                                        Kuriyer
                                                        @break
                                                    @case('package')
                                                        Bağlama
                                                        @break
                                                    @case('cash')
                                                        Nağd
                                                        @break
                                                    @default
                                                        {{ ucfirst($log->type) }}
                                                @endswitch
                                            </h6>
                                            <p class="thumbnail-balances-transactions__desc">{{$log->created_at}}</p>
                                        </div>
                                        <p class="thumbnail-balances-transactions__price font-n-b
                                            {{ $log->status === 'in' ? 'thumbnail-balances-transactions__price--green' : 'thumbnail-balances-transactions__price--red' }}">
                                            {{ $log->status === 'in' ? '+' : '-' }}{{$log->amount}} USD
                                        </p>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        @if(count($logs)>0)
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="#" class="profile-more-btn d-flex justify-content-center align-items-center">
                                <span class="profile-more-btn__title font-n-b">Daha çox</span>
                                <img class="profile-more-btn__img" src="/web/images/content/profile-more.png" alt="More">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal modal-profile-balance-add fade" id="modalProfileBalanceAdd" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-profile-balance-add__dialog center-block">
            <div class="modal-content modal-profile-balance-add__content">
                <div class="modal-header modal-profile-balance-add__header justify-content-end">
                    <img class="modal-profile-balance-add__img-close" src="/web/images/content/modal-close.png" alt="Modal Close" data-bs-dismiss="modal">
                </div>
                <div class="modal-body modal-profile-balance-add__body">
                    <form class="form form-modal-profile form-modal-profile-balance-add center-block" name="formModalProfileLogout" id="formModalProfileBalanceAdd" method="post" action="{{route("post_balance_page", ['locale' => App::getLocale()])}}" novalidate="novalidate">
                        @csrf
                        <h6 class="form-modal-profile__title form-modal-profile-balance-add__title text-center font-n-b">Balans artımı</h6>
                        <div class="form__group">
                            <label class="form__label" for="balanceCurrency">Valyuta seçin</label>
                            <div class="form__select-wrapper">
                                <select class="form__select" name="balance_currency" id="balanceCurrency" required>
                                    <option value="1">USD</option>
                                </select>
                            </div>
                        </div>
                        <div class="form__group">
                            <label class="form__label" for="balanceAmount">Məbləği daxil edin</label>
                            @if($amount == 0)
                                <input class="form__input" name="amount" type="text" id="balanceAmount" required>
                            @else
                                <input class="form__input" name="amount" type="text" id="balanceAmount" value="{{ $amount }}" required>
                            @endif

                        </div>
                        <div class="form__group">
                            <button class="btn btn-blue btn-block form__btn form-modal-profile__btn form-modal-profile-balance-add__btn font-n-b" name="formModalProfileBalanceAddSubmit" type="submit">Balans artırın</button>
                        </div>
                        <div class="form__group">
                            <button class="btn btn-trns-black btn-block form__btn form-modal-profile__btn form-modal-profile-balance-add__btn font-n-b" type="button" data-bs-dismiss="modal">Bağla</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script>
    $(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const amount = urlParams.get('amount');

    if (amount) {
        $('#modalProfileBalanceAdd').modal('show');
    }
});
</script>
@endsection