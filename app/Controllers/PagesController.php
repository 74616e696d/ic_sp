<?php

namespace App\Controllers;
use Illuminate\View\Factory as View;

class PagesController extends BaseController
{
    public function about()
    {
        return $this->render('public.about', []);
    }

    public function userManual()
    {
        return $this->render('user_manual',[
           
        ]);
    }

    public function faq()
    {
        $faqs=[
            [
                'ques'=>'How can I be a member here?',
                'ans'=>'Go to your “User Panel”, scroll down to the bottom. You will find an option called “My Membership
                Plan”. The options and procedures are given there. Please call 01994333333 for more details.'
            ],
            [
                'ques'=>'I have paid the amount of money for my account to activate, but the Locked Options are still locked.
            What to do?',
            'ans'=>'After payment please send an SMS with your email address to the same number with last 3 digits of
            Transaction ID. After half an hour, logout from your account and login with the email address you sent 
            the SMS to us.'
            ],
            ['ques'=>'I have paid the amount of money for a specific package; I have also sent the SMS to the following
            number. It has been over half an hour, but my account is still locked. What to do?',
            'ans'=>'Please call on the given number and let us know about the delay.Phone Number:  01994333333; 01917777021<p>N.B: If nobody picks up, your account will still be activated within 24 hours.</p>'
            ],
            ['ques'=>'How can I send money for Activating my Account?','ans'=>'Please Bkash the package amount to the given Number: 01917777021'],
            ['ques'=>'I forgot my password. How can I resolve this issue?','ans'=>'There is an option "Forgot Password?” on the home screen. Click on the option. Then give your email address that you used to login to Iconpreparation. A link will be sent to your email address. Click on the link and then you will be able to change your password of your Iconpreparation account.'],
            ['ques'=>'What is the process of upgrading my account?','ans'=>'You can update your membership by paying online using Bkash/ Master card/ Visa card.
        If you don’t have any of these, you can pay from a Bkash agent.'],
            ['ques'=>'While logging in through Mobile, the page stays blank or error occurs. What to do?','ans'=>'Try logging in through a different browser. This problem generally occurs with “Opera
        Mini” Browser.'],
            ['ques'=>'How do I use this website for my preparation?','ans'=>'You should go through the chapters one by one. Read the chapter details first. Then go
        through the practice question portion. If you think you are ready, test yourself with the “Quiz”portion. You should not move onto next chapter if you haven’t got more than 90% of the full 
        marks. If you fail to do so, go through the chapter details again, then take the quiz. Best of luck. 
        '],
            ['ques'=>'How to review my Model Test Result?','ans'=>'You have to go through all the questions and at the end the “Next” options changes into
        “Finish and Submit”. Click on the option and you will get your result.'],
            ['ques'=>'How do I get the correct answers of the model test I have just taken?','ans'=>'Submit your answers after giving the test. A page with your test result will appear. On the
        upper Left corner of the result box, there is an option “View All”. By clicking onto that option 
        you will get all the questions at once with your answers as well as the correct ones. The page 
        takes time to load, please have patience with us.'],
            ['ques'=>'What is the bonus that I will get by sharing my test score on Facebook?','ans'=>'You will get 10% discount on your next purchase of membership plan.'],
            ['ques'=>'What is the next step after Bkash payment?','ans'=>'After payment please send an SMS with your email address to the same number with last 3 digit of
        Transaction ID.'],
            ['ques'=>'How can I see the Model Tests that I have taken?','ans'=>'There is an option “My Statistics”, click on it then select “Model Test Results”. You will find all the
        test results you have taken previously.'],
            ['ques'=>'Can I use Iconpreparation through my Mobile Phone?','ans'=>'Yes, you can use iconpreparation.com from any Android Devices.'],
            ['ques'=>'What is “User Panel”?','ans'=>'This is the home page of your account with Iconpreparation. You can find few pop-up shortcuts to your
        desired query as well as systematically listed options and layout of the page.'],
            ['ques'=>'What is “Read and Practice”?','ans'=>'In this page, you can read the content of your required examination preparation chapter wise as
        well as you can practice through sample questions.'],
            ['ques'=>'What is ”Previous Job Test”?','ans'=>'You can go through the questions of previous job tests here as well as take the tests and judge your
        preparations.'],
            ['ques'=>'What is “Model Tests”?','ans'=>'In this section you can give model tests of your desired examinations. The results are given
        instantaneously.'],
            ['ques'=>'What is “Current Affairs”?','ans'=>'In this section, you will find all the current news and affairs up to date.'],
            ['ques'=>'What is “Mistake List”?','ans'=>'In this section, all of your mistakes are recorded. This includes Mistakes from Model Tests, Quizzes,
        Practice section etc. These questions are there for you to recheck again.'],
            ['ques'=>'What is “Review List”?','ans'=>'In this section, all of your questions added to review list during taking a model test are included.This helps to check a question you didn’t know, even if you have hit the correct answer without knowing.'],
            ['ques'=>'What is “My Statistics”?','ans'=>'In this section, you will find all of your results and statistics regarding your result. This section is divided into Exams, Quizzes, Model Tests and your strength in particular chapters with comparison.'],
            ['ques'=>'What is “Important Rules”?','ans'=>'In this section, you will find important tricks to memorize some hard questions. This section is updated every day.'],
            ['ques'=>'What is Iconpreparation Forum”','ans'=>'This is an educational forum, where different important and interesting topics are discussed with the users. Simply, this is a discussion section.'],
            ];
        
        //return $this->view->run('public.faq', ['faqs' => $faqs]);
        return $this->render('public.faq',[
            'faqs' => $faqs
        ]);
    
    }
}