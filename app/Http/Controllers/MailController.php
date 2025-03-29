<?PHP
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Mail;
use PDF;
use App\Mail\DemoMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
    
class MailController extends Controller
{
    /**
     * Write code on Method
     * @return response()
     */
    public function index(Request $request)
    {
        //dd($request->all());
        $mailData['title'] = $request->title;
        $mailData['body']  = $request->body;
    
        $user_email = $request->email;

        $pdf = PDF::loadView('emails.myTestMail', $mailData);
        $mailData["pdf"] = $pdf;

           
        Mail::to($user_email)->send(new DemoMail($mailData));
             
        //dd("Email is sent successfully.");
        return redirect()->route('home')
    ->with('success', 'Mail Send successfully.');
    }



}
