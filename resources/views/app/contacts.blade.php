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
                                    <a href="javascript:void(0)" class="comment card-footer-p position-relative d-block w-100"><img src="/img/contacts/comment.svg" alt="Comment" class="comment-img"></a>
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

    <script>
            document.querySelector("#review_modal").addEventListener('click', function(){
                var form = document.createElement("div");
                form.innerHTML = `
                    <div class="new-url-modal contact-modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    <img src="/img/contacts/comment-modal.svg" alt="icon-file-add">
                                    Reviews
                                </h5>
                            </div>
                            <div class="modal-body">
                                <div class="review-content">
                                    <div class="review-single">
                                        <p class="mb-0 secondary-color mb-2 font-12 text-start"><span class="pe-2">Han Solo</span><span>1 day ago</span></p>
                                        <p class="review-text pb-1 mb-2 black-color-85 text-start font-14">We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.</p>
                                        <div class="star-bg">
                                            <span class="star-rating" style="width: 100%;"></span>
                                        </div>
                                    </div>
                                    <div class="review-single">
                                        <p class="mb-0 secondary-color mb-2 font-12 text-start"><span class="pe-2">Han Solo</span><span>1 day ago</span></p>
                                        <p class="review-text pb-1 mb-2 black-color-85 text-start font-14">We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.</p>
                                        <div class="star-bg">
                                            <span class="star-rating" style="width: 60%;"></span>
                                        </div>
                                    </div>
                                    <div class="review-single">
                                        <p class="mb-0 secondary-color mb-2 font-12 text-start"><span class="pe-2">Han Solo</span><span>1 day ago</span></p>
                                        <p class="review-text pb-1 mb-2 black-color-85 text-start font-14">We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.</p>
                                        <div class="star-bg">
                                            <span class="star-rating" style="width: 50%;"></span>
                                        </div>
                                    </div>
                                    <div class="review-single">
                                        <p class="mb-0 secondary-color mb-2 font-12 text-start"><span class="pe-2">Han Solo</span><span>1 day ago</span></p>
                                        <p class="review-text pb-1 mb-2 black-color-85 text-start font-14">We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.</p>
                                        <div class="star-bg">
                                            <span class="star-rating" style="width: 50%;"></span>
                                        </div>
                                    </div>
                                    <div class="review-single">
                                        <p class="mb-0 secondary-color mb-2 font-12 text-start"><span class="pe-2">Han Solo</span><span>1 day ago</span></p>
                                        <p class="review-text pb-1 mb-2 black-color-85 text-start font-14">We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.</p>
                                        <div class="star-bg">
                                            <span class="star-rating" style="width: 85%;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-add">
                                    <div class="rating"> 
                                        <input type="radio" name="rating" value="5" id="5">
                                        <label for="5"><i class="fa-solid fa-star"></i></label> 
                                        <input type="radio" name="rating" value="4" id="4">
                                        <label for="4"><i class="fa-solid fa-star"></i></label> 
                                        <input type="radio" name="rating" value="3" id="3">
                                        <label for="3"><i class="fa-solid fa-star"></i></label> 
                                        <input type="radio" name="rating" value="2" id="2">
                                        <label for="2"><i class="fa-solid fa-star"></i></label> 
                                        <input type="radio" name="rating" value="1" id="1">
                                        <label for="1"><i class="fa-solid fa-star"></i></label>
                                    </div>
                                    <div>
                                        <textarea class="form-control rounded-0 textarea-contact" name="comment" id="comment" placeholder="Please, add your review here." rows="4"></textarea>    
                                        <p class="text-end font-14 black-color-25">0/100</p>
                                    </div>    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Add Review</button>
                            </div>
                        </div>
                    `;
                    Swal.fire({
                    html: form,
                    showCloseButton: true,
                    showConfirmButton: false,
                    customClass: {
                        container: 'review-container',
                        popup: 'review-popup',
                    }
                    
                });
            });
        </script>    

@endsection