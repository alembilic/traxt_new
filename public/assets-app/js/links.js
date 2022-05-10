function storeBacklinks() {
    var domain_id = $('#domain-id').val(),
        links = [];

    $('.select-url-item:checked').each(function () {
        links.push(this.value);
    });
    if (!links.length) {
        Swal.fire({
            icon: 'warning',
            title: 'Import Failed',
            text: 'Links not selected',
            showConfirmButton: true
        })
    }

    Api.makeRequest('backlinksSave', {
        data: {links: links},
        complete: function (xhr) {
            if (xhr.status === 204) {
                Swal.fire({
                    icon: 'success',
                    title: 'Import Complete',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload()
                });
            }
        }
    }, {domain: domain_id});
}

function loadBackLinks(domain_id) {
    Api.makeRequest('backlinksRetrieve', {
        success: function (data) {
            if (!data.data.length) {
                $('.Found-modal-table tbody').html('<tr><td colspan="7" class="align-center">No backlinks found</td></tr>');
            } else {
                $('.Found-modal-table tbody').html('');
            }
            $(data.data).each(function (key, item) {
                $('.Found-modal-table tbody').append('<tr>' +
                    '<td>' +
                    '<div class="form-check"><input type="checkbox" class="form-check-input select-url-item" value="' +
                        item['destUrl'] + item['sourceUrl'] + '"' + ((maxLinks - linksCount) <= 0 ? ' disabled=""' : '') + '></div>' +
                    '<input type="hidden" class="searchable-data" value="' + item['destUrl'] + item['sourceUrl'] + '">' +
                    '</td>' +
                    '<td><a href="' + item['sourceUrl'] + '">' + item['sourceUrl'] + '</a></td>' +
                    '<td>' + item['rank'] + '</td>' +
                    '<td>' + (item['doFollow'] ? 'Yes' : 'No') + '</td>' +
                    '<td>' + formatDate(new Date(item['activeSince'])) + '</td>' +
                    '<td>' + (item['isLost'] ? formatDate(new Date(item['linkLost'])) : 'No') + '</td>' +
                    '<td><a href="' + item['destUrl'] + '">' + item['destUrl'] + '</a></td>' +
                    '</tr>');
            });
        }
    }, {domain: domain_id});
}

function formatDate(date) {
    return date.getFullYear() + '-' + (date.getMonth() < 9 ? 0 : '') + (date.getMonth() + 1) + '-' + date.getDate() +
        ' ' + (date.getHours() < 10 ? 0 : '') + date.getHours() + ':' + (date.getMinutes() < 10 ? 0 : '') +
        date.getMinutes() + ':' + (date.getSeconds() < 10 ? 0 : '') + date.getSeconds();
}

function getSectionItem(v, line) {
    var firstSeen = new Date(v['firstSeen']),
        lastSeen = new Date(v['lastSeen']),
        dateOptions = {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };
    return `<tr class="sub-line line-` + line + `">
            <td>
                <div class="d-flex align-items-xl-center flex-xl-row flex-column">
                    <div><span class="text-grey d-block">` +
                        (v['statusCode'] !== 200
                            ? '<i class="fa-solid fa-circle-xmark"></i> '
                            : v['isLost']
                                ? '<i class="fa-solid fa-circle-exclamation"></i> '
                                : '<img src="/assets-app/images/icon-tag.svg" alt="icon-tag"> ') +
                            v['sourceUrl'] + `
                        </span>
                    </div>
                </div>
            </td>
            <td><input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*?)\\..*/g, '$1');" class="form-control table-font-14 black-text price" value="` + (v['price'] ? v['price'] : '') + '" data-id="' + v['id'] + '" data-price="' + v['price'] + `"></td>
            <td class="text-center"><span class="badge badge-orange d-inline-block">` + v['rank'] + `</span></td>
            <td class="text-center">` + v['spamScore'] + `</td>
            <td>` + (v['isNoFollow'] ? 'No' : 'Yes')  + `</td>
            <td class="text-center">` + v['statusCode'] + `</td>
            <td class="text-center">Not included</td>
            <td class="text-center">` + firstSeen.toLocaleDateString("en-US", dateOptions) + `,<br />` + lastSeen.toLocaleDateString("en-US", dateOptions) + `</td>
            <td>
                <div class="d-flex align-items-center justify-content-end flex-wrap">
                    <a href="#" class="d-inline-block mx-lg-2 mx-1 delete-single-link" data-id="` + v['id'] + `" data-line="` + line + `">
                        <img src="/assets-app/images/icon-delete.svg" alt="icon-delete" class="action-img">
                    </a>
                </div>
            </td>
        </tr>`;
}

function isChanged() {
    return !!(Object.keys(changesCollection).length);
}

function validateChanges() {
    if (isChanged()) {
        $('.import-backlinks').hide();
        $('.add-backlink').addClass('d-none').removeClass('d-lg-flex');

        $('.save-price').addClass('d-block').removeClass('d-none');
        $('.undo-price').addClass('d-block').removeClass('d-none');
    } else {
        $('.import-backlinks').show();
        $('.add-backlink').removeClass('d-none').addClass('d-lg-flex');

        $('.save-price').removeClass('d-block').addClass('d-none');
        $('.undo-price').removeClass('d-block').addClass('d-none');
    }
}

function clearChanges() {
    changesCollection = {};
    validateChanges();
}

function savePrices() {
    Api.makeRequest('updateBacklinkPrices', {
        data: {links: changesCollection},
        complete: function (xhr) {
            if (xhr.status === 201) {
                Swal.fire({
                    icon: 'success',
                    title: 'Prices Updated',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    clearChanges();
                });
            }
        }
    }, {});

    return false;
}

function undoPrices () {
    $('.price').each(function () {
        this.value = $(this).data('price');
    });

    clearChanges();

    return false;
}

var changesCollection = {};
$(function () {
    $('body').on('click', '#select-all', function () {
        $('.select-url-item').prop('checked', this.checked);
        $('#count-selected').html(parseInt($('.select-url-item:checked').length));
    });
    $('body').on('change', '.select-url-item', function () {
        if (parseInt($('.select-url-item:checked').length) >= (maxLinks - linksCount)) {
            $('.select-url-item').prop('disabled', true);
            $('.select-url-item:checked').prop('disabled', false);
        } else {
            $('.select-url-item').prop('disabled', false);
        }
    });
    $('body').on('keyup', '.search-urls', function () {
        var search = this.value.toLowerCase().trim();
        if (!search) {
            $('.table-responsive tbody tr').show();
        } else {
            $('.table-responsive tbody tr').each(function () {
                var searchableData = $('.searchable-data', this).val().toLowerCase().trim();
                if (searchableData.indexOf(search) < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }
    });
    $('body').on('click', '.add-line', function () {
        var item = `<div class="input-group mb-3">
                        <span class="input-group-text">https://</span>
                        <input type="text" class="form-control new-url-item" placeholder="traxr.net/url">
                    </div>`;

        $('.add-line').before($(item));
    });
    $('body').on('click', '.create-backlinks', function () {
        var isActive = $('.extended-input').eq(0).hasClass('active'), items = [];
        if (isActive) {
            $('.new-url-item').each(function () {
                items.push('https://' + this.value);
            });
        } else {
            var lines = $('.string-urls').val().trim().split("\n");
            $(lines).each(function (k, v) {
                if (v.trim()) {
                    items.push(v.trim());
                }
            });
        }

        if (!items.length) {
            return ;
        }
        Api.makeRequest('storeBacklinkSection', {
            data: {
                links: items
            },
            complete: function (xhr) {
                if (xhr.status === 201) {
                    Swal.fire({
                        icon: 'success',
                        title: 'BackLink Created',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload()
                    });
                }
            }
        }, {});
    });
    $('body').on('click', '.open-section', function () {
        var tr = $(this).parent().parent().parent().parent(),
            id = $(this).data('id');
        if ($(this).hasClass('opened')) {
            $('.line-' + id).hide();
            tr.show();
            $(this).removeClass('opened').addClass('closed')
            return false;
        } else {
            $('.line-' + id).show();
            $(this).removeClass('closed').addClass('opened')
        }
        if ($(this).hasClass('loaded')) {
            return false;
        }

        $(this).addClass('loaded');
        Api.makeRequest('getBacklinkSection', {
            success: function (data) {
                $(data.data).each(function (k, v) {
                    $(getSectionItem(v, id)).insertAfter(tr);
                });

            }
        }, {backLink: id});

        return false;
    });
    $('body').on('click', '.delete-single-link', function () {
        var id = $(this).data('id'), line = $(this).data('line');
        Swal.fire({
            title: 'Are you sure?',
            text: 'you want to delete this backlink',
            icon: 'warning',
            closeOnConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Api.makeRequest('removeBacklink', {
                    complete: function (xhr) {
                        if (xhr.status === 204) {
                            Swal.fire({
                                icon: 'success',
                                title: 'BackLink Removed',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                if ($('[data-line=' + line + ']').length <= 2) {
                                    location.reload()
                                } else {
                                    $('[data-id=' + id + ']').parent().parent().parent().remove();
                                }
                            });
                        }
                    }
                }, {backLink: id});
            }
        });

        return false;
    });
    $('body').on('keyup', '.price', function () {
        var backLinkId = $(this).data('id'),
            newValue = this.value,
            currentValue = $(this).data('price');

        if (currentValue !== newValue) {
            changesCollection[backLinkId] = newValue;
        } else {
            delete changesCollection[backLinkId];
        }
        validateChanges();
    });
    $('.add-backlink').on('click', function () {
        var form = document.createElement("div");
        form.innerHTML = `
            <div class="new-url-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <img src="/assets-app/images/icon-file-add.svg" alt="icon-file-add">
                            Import New URL’s
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                        <div class="extended-input active">
                            <h6 class="text-start">Enter URL</h6>
                            <div class="input-group mb-3">
                                <span class="input-group-text">https://</span>
                                <input type="text" class="form-control new-url-item" placeholder="traxr.net/url">
                            </div>
                            <a href="#" class="add-link py-2 add-line">
                                <img src="/assets-app/images/icon-plus-black.svg" alt="icon-plus-black">
                                Add New URL
                            </a>
                        </div>
                        <div class="extended-input">
                            <h6 class="text-start">Enter URL’s</h6>
                            <textarea class="form-control string-urls" placeholder="Autosize height based on content lines"></textarea>
                            <p class="text-start">Enter one URL per line</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary create-backlinks">Import URL’s</button>
                    </div>
                </div>
            `;
        Swal.fire({
            html: form,
            showCloseButton: true,
            showConfirmButton: false,
        });
    });

    $('.add-backlinks').on('click', function () {
        var form = document.createElement("div");
        form.innerHTML = ` <div class="Found-modal">
            <input type="hidden" id="domain-id" value="` + $(this).attr('rel') + `" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <img src="/assets-app/images/pin-vector.svg" alt="pin-vector">
                        Found backlinks for ` + $(this).html() + `
                    </h5>
                    <form class="input-group model__search">
                    <input class="form-control search-urls" type="search" placeholder="search link">
                        <button class="btn" type="button">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.1022 14.1183L10.4647 9.4808C11.1844 8.55045 11.5737 7.41295 11.5737 6.21652C11.5737 4.78437 11.0147 3.44152 10.004 2.42902C8.9933 1.41652 7.64687 0.859375 6.21652 0.859375C4.78616 0.859375 3.43973 1.4183 2.42902 2.42902C1.41652 3.43973 0.859375 4.78437 0.859375 6.21652C0.859375 7.64687 1.4183 8.9933 2.42902 10.004C3.43973 11.0165 4.78437 11.5737 6.21652 11.5737C7.41295 11.5737 8.54866 11.1844 9.47902 10.4665L14.1165 15.1022C14.1301 15.1158 14.1463 15.1266 14.164 15.134C14.1818 15.1414 14.2009 15.1452 14.2201 15.1452C14.2393 15.1452 14.2584 15.1414 14.2761 15.134C14.2939 15.1266 14.3101 15.1158 14.3237 15.1022L15.1022 14.3254C15.1158 14.3118 15.1266 14.2957 15.134 14.2779C15.1414 14.2602 15.1452 14.2411 15.1452 14.2219C15.1452 14.2026 15.1414 14.1836 15.134 14.1658C15.1266 14.148 15.1158 14.1319 15.1022 14.1183ZM9.04509 9.04509C8.28795 9.80045 7.28437 10.2165 6.21652 10.2165C5.14866 10.2165 4.14509 9.80045 3.38795 9.04509C2.63259 8.28795 2.21652 7.28437 2.21652 6.21652C2.21652 5.14866 2.63259 4.1433 3.38795 3.38795C4.14509 2.63259 5.14866 2.21652 6.21652 2.21652C7.28437 2.21652 8.28973 2.6308 9.04509 3.38795C9.80045 4.14509 10.2165 5.14866 10.2165 6.21652C10.2165 7.28437 9.80045 8.28973 9.04509 9.04509Z" fill="black" fill-opacity="0.45"/>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table Found-modal-table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="select-all" ` + (maxLinks - linksCount ? '' : ' disabled') + `>
                                        </div>
                                    </th>
                                    <th class="col__2">Domain From</th>
                                    <th width="82">Rank</th>
                                    <th width="114">Do follow</th>
                                    <th class="col__5">Active since</th>
                                    <th width="80">Link lost</th>
                                    <th width="300">Domain to</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="storeBacklinks()">Import URL’s</button>
                </div>
            </div>
        </div>`;
        Swal.fire({
            html: form,
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                container: 'Found-container',
                popup: 'Found-popup',
            },
            confirmButtonText: 'Start Import',
            confirmButtonColor: 'green',
            showLoaderOnConfirm: true,
        });
        loadBackLinks($(this).attr('rel'));
        return false;
    });

    $('.delete-link').on('click', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'you want to delete this backlink',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Api.makeRequest('removeBacklinkSection', {
                    complete: function (xhr) {
                        if (xhr.status === 204) {
                            Swal.fire({
                                icon: 'success',
                                title: 'BackLink Removed',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload()
                            });
                        }
                    }
                }, {backLink: id});
            }
        });

        return false;
    });
    $('.save-price').on('click', savePrices);
    $('.undo-price').on('click', undoPrices);
});
