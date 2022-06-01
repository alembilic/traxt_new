<?php

namespace App\Http\Controllers;

use App\Core\EntityManagerFresher;
use Exception;
use Illuminate\View\View;

class RewardsController extends BaseWebController
{
    use EntityManagerFresher;

    /**
     * @throws Exception
     */
    private function generateAndSetReferralCode(): string
    {
        $this->user->setReferralCode();
        $this->getEntityManager()->persist($this->user);
        $this->getEntityManager()->flush();
        return $this->user->getReferralCode();
    }

    /**
     * @throws Exception
     */
    public function index(): View
    {
        $referralCode = $this->user->getReferralCode();
        if (!$referralCode) {
            $referralCode = $this->generateAndSetReferralCode();
        }

        return view('app.rewards', [
            'referralCode' => $referralCode,
            'id' => $this->user->getId(),
        ]);
    }
}
