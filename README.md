<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Auth Forget Password and send email functionality in laravel 11

- ✅ In this Post, I will show how to install Bootstrap auth scaffolding in a Laravel 11 application.
- ✅ Laravel provides a UI package for the easy setup of auth scaffolding. Laravel UI offers simple authentication features, including login, registration, password reset, email verification, and password confirmation, using Bootstrap
- In this tutorial, I will provide you with simple steps on how to install Bootstrap 5 and how to create auth scaffolding using Bootstrap 5 in Laravel 11.

- You can clone or download the zipfile after that extracted and paste the pest the folder you want.
- Make the .env file through .env.example
- Run the following commands

````
composer update
````
````
php artisan migrate
````
````
php artisan serve
````

**If you want to install then follow some steps which your help to understand the laravel implementation process**
- Run command and get clean fresh laravel new application.

- ✅ Step 1: Install Laravel 11
- ✅ Step 2: Install Laravel UI
- ✅ Step 3: Create Authentication
- ✅ Step 4: NPM Install Run Dev
- ✅ Step 5: Create Migration
- ✅ Step 6: Mail configurtion
- ✅ Step 7: Install dompdf Package
- ✅ Step 8: Create Controller
- ✅ Step 9: Create Blade
- ✅ Step 10: Create route
- ✅  Run Application


- ✅ Steps 1 First of all, we need to get a fresh Laravel 11 version application using the command below because we are starting from scratch. So, open your terminal or command prompt and run the command:

````
composer create-project "laravel/laravel:^11.0" my-app
````
- Setup the <b>.env file</b>

````
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lara11_auth_mail
DB_USERNAME=root
DB_PASSWORD=
````

- ✅ Steps 2, We need to install the Laravel UI package

````
composer require laravel/ui
````

- ✅ Steps 3,Next, you have to install the Laravel UI package command for creating auth scaffolding using Bootstrap 5. So let's run the command:

````
php artisan ui bootstrap --auth
````
- ✅ Steps 4, Now let's run the below command to install npm:

````
npm install
````
- It will generate CSS and JS min files.
````
npm run build
````
- ✅ Steps 5, Next run the migration command:

````
php artisan migrate
````

- ✅ Steps 6, this step you have to add the mail configuration. Set the mail driver as "gmail", the mail host, mail port, mail username, and mail password. Laravel 11 will use these sender details for emails. You can simply add them as follows:

````
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=mygoogle@gmail.com
MAIL_PASSWORD=rrnnucvnqlbsl
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=mygoogle@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

````
- Make sure you have to enable Google security setting from your Gmail. Go to Google account and click on "Account". Once you are on the "Account" page, click on "Security". Scroll down to the bottom and you will find "Less secure app access" settings. Set it as ON.

- we will create a mail class called `DemoMail` for sending emails. Here, we will write code for which view will be called and the object of the user. So let's run the command.

````
php artisan make:mail DemoMail
````
- Now, let's update the code in the `DemoMail.php` file as follows:
- app/Mail/DemoMail.php

````
<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
  
class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }
  
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailData['title'],
        );
    }
  
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.myTestMail',
            with: $this->mailData
        );
    }
  
    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [
        Attachment::fromData(fn () => $this->mailData['pdf']->output(), 'Report.pdf')
                ->withMime('application/pdf'),];
    }
}

````

- ✅ Steps 7, we will install the barryvdh/laravel-dompdf composer package by following the composer command in your Laravel application.

````
composer require barryvdh/laravel-dompdf
````

- ✅ Steps 8, In this step we will create a `MailController` with an `send_mail()` method where we will write code to send an email to a given email address. So first, let's create the controller by executing the following command and update the code in it:

````
php artisan make:controller MailController
````

- Now, update the code in the MailController file. app/Http/Controllers/MailController.php

````
<?PHP
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Mail;
use PDF;
use App\Mail\DemoMail;
    
class MailController extends Controller
{
    /**
     * Write code on Method
     * @return response()
     */
    public function index(Request $request)
    {
        $mailData = [
            'title' => $request->title,
            'body' => $request->body
        ];

        $user_email = $request->user_email;

        $pdf = PDF::loadView('emails.myTestMail', $data);
        $data["pdf"] = $pdf;

           
        Mail::to($user_email)->send(new DemoMail($mailData));
             
        dd("Email is sent successfully.");
    }



}
````
- ✅ Steps 9, In this step, let's create myTestMail.blade.php for the layout of the PDF file and put the following code:
- resources/views/emails/myTestMail.blade.php

````
<!DOCTYPE html>
<html>
<head>
    <title>TestMail</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $body }}</p>
     
    <p>Thank you</p>
</body>
</html>

````

- resources/views/home.blade.php

````
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                     @session('success')
                     <div class="alert alert-success" role="alert"> {{ $value }} </div>
                     @endsession

                    <form method="POST" action="{{ route('send-mail') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            </div>
                        </div>
                         <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Body') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="body" required></textarea>

                              
                            </div>
                        </div>

                     

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Mail') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

````


- ✅ Steps 10, In this step, we need to create routes for item listings. So open your routes/web.php file and add the following route.

````
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/send-mail', [App\Http\Controllers\MailController::class, 'index'])->name('send-mail');

````

- All the required steps have been done, now you have to type the given below command and hit enter to run the Laravel app:

````
php artisan serve
````
- Now, Go to your web browser, type the given URL and view the app output [URL](http://localhost:8000)





