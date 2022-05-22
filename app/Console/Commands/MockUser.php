<?php

namespace App\Console\Commands;

use App\Core\EntityManagerFresher;
use App\Entities\Product;
use App\Entities\User;
use Auth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MockUser extends Command
{
    use EntityManagerFresher;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mock:user {--email=} {--plan=?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create User with email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $em = $this->getEntityManager();
        $planId = $this->option('plan');
        $email = $this->option('email');
        $password = Str::random('10');

        $product = $em->getRepository(Product::class)->findOneBy([
            Product::MIX_ID => $planId,
        ]);
        $rules = [
            'username' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'company' => ['required', 'string'],
            'vat_number' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'country' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'max:100', 'min:8'],
        ];
        $data = [
            'username' => $email,
            'firstname' => 'Name ' . rand(0, 100),
            'lastname' => 'LastName ' . rand(0, 100),
            'company' => Str::random('5'),
            'vat_number' => Str::random('5'),
            'vat_valid' => '',
            'city' => 'Copenhagen',
            'address' => 'Asd 12',
            'country' => 'DK',
            'email' => $email,
            'password' => $password,
            'plan' => $planId,
        ];

        $validator = Validator::make($data, $rules);
        if (!$validator->fails()) {
            $user = new User($data);
            $em->persist($user);
            $em->flush();
            Auth::attempt($data, true);

            $this->info('User created.');
            $this->info('Login: ' . $email);
            $this->info('Password: ' . $password);
        } else {
            $this->error('Error: ' . collect($validator->errors()->toArray())->join(', '));
        }

        return 0;
    }
}
