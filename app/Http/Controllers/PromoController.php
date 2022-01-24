<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PromoController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Send `Get in touch` form.
     *
     * @param Request $request request data
     */
    public function sendMail(Request $request): void
    {
        //FIXME: move this to a queues
        $headers = "From: Traxr Contact Form <sales@traxr.net>\r\n";
        $headers .= "Reply-To: ".addslashes($_POST['email'] ?? '')."\r\n";
        $headers .= "Return-Path: sales@traxr.net\r\n";
        $firstname = addslashes($_POST['name'] ?? '');
        $from = "From: Traxr Contact Form <sales@traxr.net>";
        $subject = "Message from Contact Form from ".addslashes($_POST['name'] ?? '');
        $body = "Email: ".addslashes($_POST['email'] ?? '')."\r\n"
            ."Name: ".addslashes($_POST['name' ?? ''])."\r\n"
            ."Wrote: ".addslashes($_POST['message'] ?? '');
        if (mail("sales@traxr.net", utf8_decode($subject), utf8_decode($body), $headers)) {
            header("Location: /contact?success=1");
        } else {
            header("Location: /contact?failed=1");
        }
        exit;
    }

}
