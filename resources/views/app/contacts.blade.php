@extends('app.app_layout')
@section('pageName')
    Contacts
@endsection

@php
/* @var \App\Entities\Contact $contacts */
@endphp

@section('title-section')
    <h1>Contacts</h1>
    <div class="contact-form">
        <form>
            <div class="postion-relative d-flex">
                <input type="text" class="form-control rounded-0 d-inline-block contact-input" name="search" id="search" placeholder="input search text" value="{{ $search }}">
                <button type="submit" class="btn btn-primary d-inline-block rounded-0 search-btn">Search</button>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="contact-width">
        <div class="row cards">
            @foreach($contacts as $contact)
                <div class="col col-md-4 col-sm-6 col-xl-3 col-12 mb-3">
                    <div class="card h-100 contact-card">
                        <div class="card-body contact-card-body">
                            <p class="contact-name black-text font-16">{{ $contact->getFullname() }}</p>
                            <p class=""><a href="javascript:void(0)" class="font-14 secondary-color">{{ $contact->getEmail() }}</a></p>
                        </div>
                        <div class="card-footer card-footer-custom bg-white p-0">
                            <div class="row text-center g-0">
                                <div class="col-6">
                                    <a href="javascript:void(0)" class="comment card-footer-p position-relative d-block w-100"><img src="images/comment.svg" alt="Comment" class="comment-img"></a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0)" id="review_modal" class="rate card-footer-p d-block text-center secondary-color "><span class="font-16 star-icon"><i class="fa-solid fa-star"></i></span class="font-14"> <span>5/5</span></a>
                                </div>
                            </div>
                        </div>
                    </div>       
                </div>
            @endforeach        
        </div>
    </div>
@endsection