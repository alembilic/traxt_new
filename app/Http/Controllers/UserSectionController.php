<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\View\View;
use NumberFormatter;

class UserSectionController extends BaseWebController
{
    public function dashboard(): View
    {
        //TODO: move this to a service layer
        /* @var User $user */
        $user = $this->user;

//        $res = $dbc->get_all_links($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_all_links = count($res);
//
//        $res_header_nofollow = $dbc->get_headers_with_nofollow($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_header_nofollow_count = count($res_header_nofollow);
//
//        $res_rel_nofollow = $dbc->get_rel_with_nofollow($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_rel_nofollow_count = count($res_rel_nofollow);
//
//        $res_non_indexed = $dbc->get_non_indexed($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_no_index = count($res_non_indexed);
//
//        $res = $dbc->get_html_links($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_html_links = count($res);
//
//        $res = $dbc->get_js_links($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_js_links = count($res);
//
//        $res_vanished = $dbc->get_notfound($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_vanished_count = count($res_vanished);
//
//        $res_link_prices = $dbc->get_link_prices($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_link_avg_prices = $dbc->get_avg_link_prices($session->id, $session->userinfo['plan'], $session->userinfo['active_plan']);
//        $res_user_currency = $dbc->getUserDashboardCurrency($session->id)[0]['currency'];
//        $res_amount_valuta = $dbc->get_amount_in_valuta($res_user_currency);
//        $res_num_prices = count($res_link_prices);
//        $required_num = 10;
//        $currency_code = $res_amount_valuta[0]['code'];
//        if ($res_user_currency == 1) {
//            $avg_price = $res_link_avg_prices[0]['price'] / $res_amount_valuta[0]['value'];
//            $fmt = numfmt_create('da_DK', NumberFormatter::DECIMAL);
//        } else {
//            $avg_price = $res_link_avg_prices[0]['price'] / $res_amount_valuta[0]['value'] * 100;
//            $fmt = numfmt_create('en_US', NumberFormatter::DECIMAL);
//        }
//
//        $res_all_ok = $res_all_links - ($res_header_nofollow_count + $res_rel_nofollow_count + $res_no_index + $res_js_links + $res_vanished_count);
//
//        $res_vanished_todo = $dbc->get_ExternalUrlData($res_vanished);
//        $res_noindex_todo = $dbc->get_ImportedUrlData($res_non_indexed);
//        $res_noheader_todo = $dbc->get_ImportedUrlData($res_header_nofollow);
//        $res_nofollow_todo = $dbc->get_ImportedUrlData($res_rel_nofollow);
//
//        return view('app.dashboard', [
//            'res_num_prices' => $res_num_prices,
//            'required_num' => $required_num,
//            'avg_price' => $avg_price,
//            'currency_code' => $currency_code,
//            'res_user_currency' => $res_user_currency,
//            'res_link_avg_prices' => $res_link_avg_prices,
//            'res_amount_valuta' => $res_amount_valuta,
//            'res_vanished_count' => $res_vanished_count,
//            'res_header_nofollow_count' => $res_header_nofollow_count,
//            'res_rel_nofollow_count' => $res_rel_nofollow_count,
//            'res_no_index' => $res_no_index,
//            'res_all_links' => $res_all_links,
//            'res_all_ok' => $res_all_ok,
//            'res_html_links' => $res_html_links,
//            'res_js_links' => $res_js_links,
//            'res_vanished_todo' => $res_vanished_todo,
//            'res_noindex_todo' => $res_noindex_todo,
//            'res_noheader_todo' => $res_noheader_todo,
//            'res_nofollow_todo' => $res_nofollow_todo,
//            'fmt' => $fmt,
//        ]);


        $fmt = numfmt_create('en_US', NumberFormatter::DECIMAL);
        return view('app.dashboard', [
            'res_num_prices' => 0,
            'required_num' => 10,
            'avg_price' => 0,
            'currency_code' => 0,
            'res_user_currency' => 0,
            'res_link_avg_prices' => 0,
            'res_amount_valuta' => 0,
            'res_vanished_count' => 0,
            'res_header_nofollow_count' => 0,
            'res_rel_nofollow_count' => 0,
            'res_no_index' => 0,
            'res_all_links' => 0,
            'res_all_ok' => 0,
            'res_html_links' => 0,
            'res_js_links' => 0,
            'res_vanished_todo' => 0,
            'res_noindex_todo' => 0,
            'res_noheader_todo' => 0,
            'res_nofollow_todo' => 0,
            'fmt' => $fmt,
        ]);
    }

    public function links(): View
    {
        return view('app.links');
    }

    public function domains(): View
    {
        return view('app.domains');
    }

    public function myAccount(): View
    {
        return view('app.my_account', ['user' => $this->user]);
    }

    public function invoices(): View
    {
        return view('app.invoices');
    }

    /**
     * @return View
     *
     * @throws BindingResolutionException
     */
    public function myPlan(): View
    {
        return view('app.my_plan', ['plan' => $this->user->getPlan()]);
    }

}
