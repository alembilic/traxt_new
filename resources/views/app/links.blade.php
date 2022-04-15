@extends('app.app_layout')
@section('pageName')
    Links
@endsection
@section('title-section')
    <div class="title">
        <h1>Links</h1>
        <div class="dropdown dropdown-filters">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                <img src="/assets-app/images/icon-filters.svg" alt="icon-filters">
                Filters
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <div class="dropdown-menu-head">
                    <h6>Filters</h6>
                    <div class="dropown-nav">
                        <button type="button" class="btn btn-link text-black">Reset</button>
                        <button type="button" class="btn btn-link">Save</button>
                    </div>
                </div>
                <form class="input-group search">
                    <input class="form-control" type="search" placeholder="input search text">
                    <button class="btn" type="submit">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1022 14.1183L10.4647 9.4808C11.1844 8.55045 11.5737 7.41295 11.5737 6.21652C11.5737 4.78437 11.0147 3.44152 10.004 2.42902C8.9933 1.41652 7.64687 0.859375 6.21652 0.859375C4.78616 0.859375 3.43973 1.4183 2.42902 2.42902C1.41652 3.43973 0.859375 4.78437 0.859375 6.21652C0.859375 7.64687 1.4183 8.9933 2.42902 10.004C3.43973 11.0165 4.78437 11.5737 6.21652 11.5737C7.41295 11.5737 8.54866 11.1844 9.47902 10.4665L14.1165 15.1022C14.1301 15.1158 14.1463 15.1266 14.164 15.134C14.1818 15.1414 14.2009 15.1452 14.2201 15.1452C14.2393 15.1452 14.2584 15.1414 14.2761 15.134C14.2939 15.1266 14.3101 15.1158 14.3237 15.1022L15.1022 14.3254C15.1158 14.3118 15.1266 14.2957 15.134 14.2779C15.1414 14.2602 15.1452 14.2411 15.1452 14.2219C15.1452 14.2026 15.1414 14.1836 15.134 14.1658C15.1266 14.148 15.1158 14.1319 15.1022 14.1183ZM9.04509 9.04509C8.28795 9.80045 7.28437 10.2165 6.21652 10.2165C5.14866 10.2165 4.14509 9.80045 3.38795 9.04509C2.63259 8.28795 2.21652 7.28437 2.21652 6.21652C2.21652 5.14866 2.63259 4.1433 3.38795 3.38795C4.14509 2.63259 5.14866 2.21652 6.21652 2.21652C7.28437 2.21652 8.28973 2.6308 9.04509 3.38795C9.80045 4.14509 10.2165 5.14866 10.2165 6.21652C10.2165 7.28437 9.80045 8.28973 9.04509 9.04509Z" fill="black" fill-opacity="0.45"/>
                        </svg>
                    </button>
                </form>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            Domain
                        </button>
                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <h6>Filer by domain</h6>
                            <select class="form-select disabled" aria-label="Default select example">
                                <option selected>Domain Name</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            Technical Features
                        </button>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkbox-13" checked>
                                <label class="form-check-label" for="checkbox-13">
                                    Headers Noindex
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkbox-14" checked>
                                <label class="form-check-label" for="checkbox-14">
                                    Rel (Nofollow, sponsored, UGC)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkbox-15">
                                <label class="form-check-label" for="checkbox-15">
                                    Not Indexed
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkbox-16">
                                <label class="form-check-label" for="checkbox-16">
                                    Vanished
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkbox-17">
                                <label class="form-check-label" for="checkbox-17">
                                    Headers Nofollow
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkbox-19">
                                <label class="form-check-label" for="checkbox-19">
                                    Respons Code Not Ok
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            Live
                        </button>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-1" id="radio-1" checked>
                                <label class="form-check-label" for="radio-1">
                                    Live
                                </label>
                            </div>
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-1" id="radio-2">
                                <label class="form-check-label" for="radio-2">
                                    Not live
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            Subdomains
                        </button>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-2" id="radio-3" checked>
                                <label class="form-check-label" for="radio-3">
                                    Exclude
                                </label>
                            </div>
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-2" id="radio-4">
                                <label class="form-check-label" for="radio-4">
                                    Include
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            Date
                        </button>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <input type="text" name="daterange" value="2020-11-08 - 2020-12-23" class="form-control form-control-daterange" />
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            Following
                        </button>
                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-3" id="radio-5" checked>
                                <label class="form-check-label" for="radio-5">
                                    No follow
                                </label>
                            </div>
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-3" id="radio-6">
                                <label class="form-check-label" for="radio-6">
                                    Do follow
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            Domain Ranking
                        </button>
                        <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-4" id="radio-7" checked>
                                <label class="form-check-label" for="radio-7">
                                    0 - 500
                                </label>
                            </div>
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-4" id="radio-8">
                                <label class="form-check-label" for="radio-8">
                                    500 - 2000
                                </label>
                            </div>
                            <div class="form-check form-radio">
                                <input class="form-check-input" type="radio" name="radio-4" id="radio-9">
                                <label class="form-check-label" for="radio-9">
                                    2000 +
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
@php
/* @var \App\Entities\BackLink $link */
/* @var \App\Entities\Domain $domain */
@endphp
<script src="/assets-app/js/links.js"></script>
<div class="links-table-wrap">
    <div class="table-header">
        <h5 class="me-auto">
            <img src="/assets-app/images/icon-link.svg" alt="icon-link">
            Your Backlinks
        </h5>
        <form class="input-group search">
            <input class="form-control" type="search" placeholder="input search text">
            <button class="btn" type="submit">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.1022 14.1183L10.4647 9.4808C11.1844 8.55045 11.5737 7.41295 11.5737 6.21652C11.5737 4.78437 11.0147 3.44152 10.004 2.42902C8.9933 1.41652 7.64687 0.859375 6.21652 0.859375C4.78616 0.859375 3.43973 1.4183 2.42902 2.42902C1.41652 3.43973 0.859375 4.78437 0.859375 6.21652C0.859375 7.64687 1.4183 8.9933 2.42902 10.004C3.43973 11.0165 4.78437 11.5737 6.21652 11.5737C7.41295 11.5737 8.54866 11.1844 9.47902 10.4665L14.1165 15.1022C14.1301 15.1158 14.1463 15.1266 14.164 15.134C14.1818 15.1414 14.2009 15.1452 14.2201 15.1452C14.2393 15.1452 14.2584 15.1414 14.2761 15.134C14.2939 15.1266 14.3101 15.1158 14.3237 15.1022L15.1022 14.3254C15.1158 14.3118 15.1266 14.2957 15.134 14.2779C15.1414 14.2602 15.1452 14.2411 15.1452 14.2219C15.1452 14.2026 15.1414 14.1836 15.134 14.1658C15.1266 14.148 15.1158 14.1319 15.1022 14.1183ZM9.04509 9.04509C8.28795 9.80045 7.28437 10.2165 6.21652 10.2165C5.14866 10.2165 4.14509 9.80045 3.38795 9.04509C2.63259 8.28795 2.21652 7.28437 2.21652 6.21652C2.21652 5.14866 2.63259 4.1433 3.38795 3.38795C4.14509 2.63259 5.14866 2.21652 6.21652 2.21652C7.28437 2.21652 8.28973 2.6308 9.04509 3.38795C9.80045 4.14509 10.2165 5.14866 10.2165 6.21652C10.2165 7.28437 9.80045 8.28973 9.04509 9.04509Z" fill="black" fill-opacity="0.45"/>
                </svg>
            </button>
        </form>
        <!--<a href="#" class="btn btn-outline-secondary  d-lg-flex Import-btn">
            Import from CSV / Excel
        </a>-->
        <div class="dorpdown position-static me-2 Automatically-dorpdown">
            <button class="btn btn-outline-secondary bg-transparent text-black d-block w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Automatically import backlinks
            </button>
            <ul class="dropdown-menu p-0 custom-dropdown-menu">
                @foreach($domains as $domain)
                <li><a class="dropdown-item active add-backlinks" href="#" rel="{{ $domain->getId() }}">{{ $domain->getDomainName() }}</a></li>
                @endforeach
            </ul>
        </div>
        <a href="#" class="btn btn-primary d-lg-flex add-backlink">
            <img src="/assets-app/images/icon-plus.svg" alt="icon-plus">
            Add New
        </a>
    </div>
    <div class="table-body">
        <table class="table table-data" id="dataTable">
            <thead>
            <tr class="width-th">
                <th class="max-width-19" width="100">
                    Source and Links
                    <button type="button" class="btn p-0 border-0" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip text here">
                        <img src="/assets-app/images/icon-info.svg" alt="icon-info ms-3">
                    </button>
                    <span class="bg-short"></span>
                </th>
                <th class="max-width-8">
                    <div class="dropdown position-static">
                        <button class="btn btn-outline-secondary p-0 dropdown-toggle d-block w-100 text-start font-weight-500 bg-transparent text-black border-0 table-font-14 " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Price <br> (USD)
                        </button>
                    </div>
                    <span class="bg-short"></span>
                </th>
                <th class="max-width-10">Domain <br> Ranking <span class="bg-short"></span></th>
                <th colspan="4" class="text-center">Technical Features <span class="bg-short"></span></th>
                <th class="max-width-10">Last Seen /<br>First seen <span class="bg-short"></span></th>
                <th class="max-width-10">Action <span class="bg-short"></span></th>
            </tr>
            <tr class="width-th">
                <th colspan="3"></th>
                <th class="max-width-10">Backlink Spam Score <span class="bg-short"></span></th>
                <th class="max-width-10">Do Follow <span class="bg-short"></span></th>
                <th class="max-width-10">Response <br>Code <span class="bg-short"></span></th>
                <th class="max-width-10">Indexed <span class="bg-short"></span></th>
                <th colspan="2"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($links as $link)
            <tr>
                <td>
                    <div class="d-flex align-items-xl-center flex-xl-row flex-column">
                        <div>
                            <a href="#" class="link">
                                {{ $link->getDomain()->getDomainName() }}
                                <i class="fa fa-arrow-down"></i>
                            </a>
                            <span class="text-grey d-block">
                                <img src="/assets-app/images/icon-tag.svg" alt="icon-tag">
                                {{ $link->getDestUrl() }}
                            </span>
                        </div>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control table-font-14 black-text" value="{{ $link->getSectionPrice() ?: '' }}" disabled>
                </td>
                <td class="text-center">
                    <span class="badge badge-orange d-inline-block">{{ $link->getRank() }}</span>
                </td>
                <td class="text-center">
                    {{ $link->getSpamScore() }}
                </td>
                <td>
                    {{ $link->isNofollow() ? 'No' : 'Yes' }}
                </td>
                <td class="text-center">{{ $link->getStatusCode() }}</td>
                <td class="text-center">Not included</td>
                <td class="text-center">{{ $link->getFirstSeen()->format('d M Y') }},<br />{{$link->getLastSeen()->format('d M Y') }}</td>
                <td>
                    <div class="d-flex align-items-center justify-content-end flex-wrap">
                        <a href="#" class="d-inline-block mx-lg-2 mx-1">
                            <img src="/assets-app/images/calendar.svg" alt="calendar" class="action-img">
                        </a>
                        <a href="#" class="d-inline-block mx-lg-2 mx-1">
                            <img src="/assets-app/images/icon-bug.svg" alt="icon-bug" class="action-img">
                        </a>
                        <a href="#" class="d-inline-block mx-lg-2 mx-1">
                            <img src="/assets-app/images/icon-edit.svg" alt="icon-edit" class="action-img">
                        </a>
                        <a href="#" class="d-inline-block mx-lg-2 mx-1">
                            <img src="/assets-app/images/icon-delete.svg" alt="icon-delete" class="action-img">
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if($of)
        @include('app.page_nav')
    @endif
</div>
@endsection
