@extends('app.app_layout')
@section('pageName')
    Domains
@endsection
@section('title-section')
    <h1>Domains</h1>
@endsection
@section('content')
@php
/* @var \App\Entities\Domain $domain */
@endphp
<div class="links-table-wrap">
    <div class="table-header">
        <h5>Your Domains</h5>
        <div class="mobile-buttons d-flex flex-wrap d-lg-none ms-auto">
            <a href="#" class="btn btn-primary add-domain">
                <img src="/assets-app/images/icon-plus.svg" alt="icon-plus">
                Add New
            </a>
        </div>
        <div class="table-nav ms-auto d-flex align-items-center">
            <form class="input-group search" method="get">
                <input class="form-control" type="search" name="search" placeholder="input search text" value="{{ $search }}">
                <button class="btn" type="submit">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.1022 14.1183L10.4647 9.4808C11.1844 8.55045 11.5737 7.41295 11.5737 6.21652C11.5737 4.78437 11.0147 3.44152 10.004 2.42902C8.9933 1.41652 7.64687 0.859375 6.21652 0.859375C4.78616 0.859375 3.43973 1.4183 2.42902 2.42902C1.41652 3.43973 0.859375 4.78437 0.859375 6.21652C0.859375 7.64687 1.4183 8.9933 2.42902 10.004C3.43973 11.0165 4.78437 11.5737 6.21652 11.5737C7.41295 11.5737 8.54866 11.1844 9.47902 10.4665L14.1165 15.1022C14.1301 15.1158 14.1463 15.1266 14.164 15.134C14.1818 15.1414 14.2009 15.1452 14.2201 15.1452C14.2393 15.1452 14.2584 15.1414 14.2761 15.134C14.2939 15.1266 14.3101 15.1158 14.3237 15.1022L15.1022 14.3254C15.1158 14.3118 15.1266 14.2957 15.134 14.2779C15.1414 14.2602 15.1452 14.2411 15.1452 14.2219C15.1452 14.2026 15.1414 14.1836 15.134 14.1658C15.1266 14.148 15.1158 14.1319 15.1022 14.1183ZM9.04509 9.04509C8.28795 9.80045 7.28437 10.2165 6.21652 10.2165C5.14866 10.2165 4.14509 9.80045 3.38795 9.04509C2.63259 8.28795 2.21652 7.28437 2.21652 6.21652C2.21652 5.14866 2.63259 4.1433 3.38795 3.38795C4.14509 2.63259 5.14866 2.21652 6.21652 2.21652C7.28437 2.21652 8.28973 2.6308 9.04509 3.38795C9.80045 4.14509 10.2165 5.14866 10.2165 6.21652C10.2165 7.28437 9.80045 8.28973 9.04509 9.04509Z"
                            fill="black" fill-opacity="0.45"/>
                    </svg>
                </button>
            </form>
            <a href="#" class="btn btn-primary d-none d-lg-flex add-domain">
                <img src="/assets-app/images/icon-plus.svg" alt="icon-plus">
                Add New
            </a>
        </div>
    </div>
    <div class="table-body">
        @if(count($domains))
        <table class="table table-data" id="dataTable">
            <thead>
            <tr>
                <th style="width: 70px">Thumb</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($domains as $domain)
                <tr>
                    <td>
                        @if($domain->getThumbUrl())
                        <img src="{{ $domain->getThumbUrl() }}" width="50"/>
                        @else
                        <i class="fas fa-spinner fa-spin"></i>
                        @endif
                    </td>
                    <td>
                        <a href="{{ $domain->getDomainUrl() }}">{{ $domain->getDomainName() }}</a>
                    </td>
                    <td>
                        <div class="item-nav">
                            <a href="#" class="remove-domain" data-id="{{ $domain->getId() }}">
                                <img src="/assets-app/images/icon-delete.svg" alt="icon-delete">
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            {!! $search ? '<div style="margin: 15px auto;text-align:center">Nothing found</div>' : '' !!}
            <div class="mobile-buttons centred-button">
            <a href="#" class="btn btn-primary add-domain">
                <img src="/assets-app/images/icon-plus.svg" alt="icon-plus">
                Create Domain
            </a>
        </div>
        @endif
    </div>
    @if($of)
        @include('app.page_nav')
    @endif
</div>
<script>
    function createDomain(domainName) {
        Api.makeRequest('createDomain', {
            data: {domain: domainName},
            success: function () {
                swal('', 'Domain Created', 'success');
                setTimeout(function() {location.reload()}, 500);
            }
        }, {});
    }
    function deleteDomain(domainId) {
        Api.makeRequest('deleteDomain', {
            success: function () {
                swal('', 'Domain Removed', 'success');
                setTimeout(function() {location.reload()}, 500);
            }
        }, {'domain': domainId});
    }
    $(function () {
        $('.add-domain').on('click', function () {
            swal({
                html: true,
                title: 'Add Domain',
                text: '<input class="form-input" name="domain" value="" />',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Add',
                confirmButtonColor: 'green',
                cancelButtonText: 'Cancel',
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                customClass: 'domain-popup'
            }, function (confirm) {
                if (confirm) {
                    createDomain($('[name="domain"]').val());
                }
            });
        });
        $('.remove-domain').on('click', function () {
            var domainId = $(this).attr('data-id');
            swal({
                html: true,
                title: 'Are you sure you want to remove domain?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: 'green',
                cancelButtonText: 'No',
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                customClass: 'domain-popup'
            }, function (confirm) {
                if (confirm) {
                    deleteDomain(domainId);
                }
            });

            return false;
        });
    });
</script>
@endsection
