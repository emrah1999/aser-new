@extends('web.layouts.web')
@section('content')
<div class="content" id="content">
    <section class="section section-questions">
        <div class="container-lg">
            {{-- <h1 class="section-title text-center font-n-b">{!! __('static.faq1', ['locale' => App::getLocale()]) !!}</h1> --}}
            <h1 class="section-title text-center font-n-b mb-3">{{$title->faqs}}</h1>
            <p class="section__desc text-center mb-5">{{$title->description_faqs}}</p>
            <div class="accordion accordion-questions" id="accordionQuestions">
               
                    <div class="row">
                        @foreach($faqs->chunk(6) as $faqChunk)
                            <div class="col-md-6">
                            @foreach($faqChunk as $faq)
                                <div class="accordion-item accordion-questions__item">
                                    <h2 class="accordion-header accordion-questions__header">
                                        <button class="accordion-button accordion-questions__button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="false">
                                            {{$faq->question}}
                                        </button>
                                    </h2>
                                    <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionQuestions{{$faq->id}}">
                                        <div class="accordion-body accordion-questions__body">
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
               
            </div>
        </div>
    </section>
</div>
@endsection
