var routes = {
    createDomain: {
        method: 'post',
        url: '/domains'
    },
    deleteDomain: {
        method: 'delete',
        url: '/domains/{domain}'
    },
    backlinksRetrieve: {
        method: 'get',
        url: '/domain/{domain}/retrieveBackLinks'
    },
    backlinksSave: {
        method: 'post',
        url: '/domain/{domain}/importBackLinks'
    },
    removeBacklinkSection: {
        method: 'delete',
        url: '/backLinks/{backLink}/source'
    },
    getBacklinkSection: {
        method: 'get',
        url: '/backLinks/{backLink}/source'
    },
    storeBacklinkSection: {
        method: 'post',
        url: '/backLinks/source'
    },
    removeBacklink: {
        method: 'delete',
        url: '/backLinks/{backLink}'
    },
    updateBacklinkPrices: {
        method: 'put',
        url: '/backLinks/syncPrices'
    },
    rating: {
        method: 'get',
        url: '/rating?contactId={contactId}'
    },
    createRating: {
        method: 'post',
        url: '/rating/create'
    }
};

var Api = {
    makeRequest: function (routeName, options, params) {
        if (routes[routeName]) {
            var route = Object.assign({}, routes[routeName]),
                domain;

            domain = '/api';

            if (params) {
                for (var prop in params) {
                    var reg = new RegExp('\{' + prop + '\}');
                    if (params.hasOwnProperty(prop)) {
                        route.url = route.url.replace(reg, params[prop]);
                    }
                }
            }

            if (options['data']
                && route.method.toLowerCase() !== 'get'
                && !(options['data'] instanceof FormData)
            ) {
                options['data'] = JSON.stringify(options['data']);
            }

            if (!options['error']) {
                options['error'] = function (xhr) {
                    handleErrors(xhr);
                    loaded = false;
                    ldg = false;
                };
            }
            options = Object.assign(options, {
                url: domain + route.url,
                type: route.method
            });

            if (options['data'] instanceof FormData) {
                options = Object.assign(options, {
                    headers: {
                        'X-Auth-Token': apiToken
                    }
                });
            } else {
                options = Object.assign(options, {
                    dataType: 'json',
                    headers: {
                        'X-Auth-Token': apiToken,
                        'Content-Type': 'application/json'
                    },

                });
            }
            $.ajax(options);
        }
    }
};

function parseErrorMessage(xhr) {
    if (xhr.readyState === 0) {
        return ['Please, try again later'];
    }
    if (xhr.status === 201 || xhr.status === 204) {
        return [''];
    }
    if (!xhr.responseText) {
        return [''];
    }
    var msg = JSON.parse(xhr.responseText), a = [];
    if (!msg.errors) {
        return [msg.message];
    }
    $.each(msg.errors, function (key, value) {
        a.push(value.join(' '));
    });

    return a;
}
function handleErrors(xhr) {
    if (xhr.readyState === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Connection failed',
            text: 'Please, try again later',
            showConfirmButton: false,
            timer: 1500
        })
    }
    if (xhr.status === 201 || xhr.status === 204) {
        return ;
    }
    if (!xhr.responseText) {
        return ;
    }
    var msg = JSON.parse(xhr.responseText), err = '', title = '', type = 'warning';
    if (!msg.errors) {
        title = msg.message;
    } else {
        $.each(msg.errors, function (key, value) {
            title += (title ? '\n' : '') + value.join(' ');
        });
    }

    Swal.fire({
        icon: type,
        title: err,
        text: title,
        showConfirmButton: false,
        timer: 1500
    })
}

if (typeof Object.assign != 'function') {
    Object.assign = function(target, varArgs) { // .length of function is 2
        'use strict';
        if (target == null) { // TypeError if undefined or null
            throw new TypeError('Cannot convert undefined or null to object');
        }

        var to = Object(target);

        for (var index = 1; index < arguments.length; index++) {
            var nextSource = arguments[index];
            if (nextSource != null) { // Skip over if undefined or null
                for (var nextKey in nextSource) {
                    // Avoid bugs when hasOwnProperty is shadowed
                    if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
                        to[nextKey] = nextSource[nextKey];
                    }
                }
            }
        }
        return to;
    };
}
