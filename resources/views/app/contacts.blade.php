@extends('app.app_layout')
@section('pageName')
    Contacts
@endsection

@php
/* @var \App\Entities\Contact $contacts */
@endphp

@section('title-section')
    <h1>Contacts</h1>
    <br />
    <div>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus alias eaque fuga, id in iusto nemo nobis non obcaecati omnis porro, quam quisquam quo quos reprehenderit sunt unde vel veniam.
    </div>
    <br />
    <div style="display: flex; flex-direction: column;">
    <div class="contact-form" >

        <form>
            <div class="postion-relative d-flex" style="width: 100%; justify-content: flex-start;">
                <input type="text" class="form-control rounded-0 d-inline-block contact-input" name="search" id="search" placeholder="input search text" value="{{ $search }}">
                <button type="submit" class="btn btn-primary d-inline-block rounded-0 search-btn">Search</button>
            </div>

        </form>

    </div>
        <div class="postion-relative d-flex btn-lg" style="padding: 1rem 0" >
        <button type="button" id="create-contact-button" class="btn btn-outline-primary text-nowrap" style="padding: 0.6rem" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Create new contact</button>
        </div>
    </div>


@endsection

@section('content')

        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new contact</h5>
                    <button type="button" class="btn-close" id="dismiss-modal-btn" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="new-contact-form" method="POST">
                        <div class="form-group row">
                            <div class="col-sm-6">
                            <label for="recipient-first-name" class="col-form-label">First name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="firstName" id="first-name">
                            </div>
                            <div class="col-sm-6">
                            <label for="recipient-last-name" class="col-form-label">Last name</label>
                            <input type="text" class="form-control" placeholder="Enter last name" name="lastName" id="last-name">
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label for="recipient-email" class="col-form-label">Email</label>
                            <input type="email" name="email" placeholder="info@traxr.net" class="form-control" id="email">
                        </div>
                        <br />
                        <!-- TODO fix full length of input field -->
                        <div class="form-group">
                        <label for="message-text" class="col-form-label">Domain</label>
                            <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">https://</span>
                            </div>

                            <input type="text" class="form-control" name="domain" id="domain" placeholder="traxr.net" >
                        </div>
                        </div>

                        <br />

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create contact</button>
                </div>


            </form>
        </div>
    </div>


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
                                    <a href="javascript:void(0)" onclick="getRatings({{ $contact->getId() }});return false;" class="comment card-footer-p position-relative d-block w-100"><img src="/img/contacts/comment.svg" alt="Comment" class="comment-img"></a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0)" onclick="getRatings({{ $contact->getId() }});return false;" class="rate card-footer-p d-block text-center secondary-color"><span class="font-16 star-icon"><i class="fa-solid fa-star"></i></span class="font-14"> <span>{{ $contact->getRating() }}/5</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <script>

        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                console.log(regexp)
                const re = new RegExp(regexp);
                return re.test(value);
            },
            "Please center a valid URL"
        );

        $('#create-contact-button').click(function (e){
            e.preventDefault()
            $('#exampleModal').modal('show')
        })

        $('#dismiss-modal-btn').click(function(e){
            e.preventDefault()
            $('#exampleModal').modal('hide')
        })


        const ratingTemplate = (rating) => {
            return `
            <div class="review-single">
                <p class="mb-0 secondary-color mb-2 font-12 text-start"><span class="pe-2">${rating.name}</span><span>${rating.created} days ago</span></p>
                <p class="review-text pb-1 mb-2 black-color-85 text-start font-14">${rating.comment}</p>
                <div class="star-bg">
                    <span class="star-rating" style="width: ${rating.percent}%;"></span>
                </div>
            </div>
        `;
        }

        const submitContactForm = $('#new-contact-form')
        console.log(submitContactForm)
        submitContactForm.validate({
           rules: {
               'first-name': {
                   required: false,
                   minlength: 2
        },
               'last-name': {
                   required: false,
                   minlength: 2
               },
               'email': {
                   email: true,
                   required: true
               },
               'domain': {
                   regex: '/((ftp|http|https):\/\/)?(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/',
                   required: true
               },

           },
            errorPlacement: function(error, element){
                error.css('color', '#ff0000')
                error.insertAfter(element);
            },
            messages: {
               'first-name': "specify name",
                'domain': {
                   url: "Domain has to be a valid URL"
                }
            },
            submitHandler: function(form, e){
                const postData = $(form).serializeArray();
                console.log(postData)
            }
       })

        const getRatings = (contactId) => {

            Api.makeRequest('rating', {

                success: function (data) {

                    console.log(data)
                    if (!data.data.length) {
                        console.log('showing modals, but no review')
                        showModal(`<div>no reviews yet</div>`, contactId);
                    } else {
                        console.log('showing ratings')
                        showModal(`${data.data.map(ratingTemplate).join("")}`, contactId);
                    }
                },
                error: function(jwXHR, exception){
                    console.error(exception)
                }

            }, {contactId: contactId});
        }

        const saveRating = () => {

            rating = $("input[name='rating']:checked").val();
            comment = $("#comment").val();
            contactId = $("#contactId").val();

            if(!comment || !rating){
                new swal('', 'Please give a rating and write a review', 'warning');
                return;
            }

            Api.makeRequest('createRating', {
                data: {value: rating, comment: comment, contactId: contactId},
                success: function (data) {
                    new swal('', 'Rating saved', 'success');
                    //TODO make better implementation, that returns new data from the api
                    setTimeout(() =>{
                        window.location.reload()
                    }, 500)

                }
            }, {});
        }

        const showModal = (ratings, contactId) => {
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
                                ${ratings}
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
                                    <input type="hidden" id="contactId" value="${contactId}"/>
                                    <p class="text-end font-14 black-color-25">0/100</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="saveRating()">Add Review</button>
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
        }

    </script>

@endsection
