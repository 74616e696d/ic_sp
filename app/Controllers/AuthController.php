<?php

namespace App\Controllers;
use Illuminate\View\Factory as View;

use App\Models\Login_model;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->validation = \Config\Services::validation();
        
        $this->loginModel = new Login_model();
    }
    
    public function login()
    {
        /*$credentials = [
			'email'    => $this->request->getPost('email'),
			'password' => $this->request->getPost('password')
		];

		$loginAttempt = auth()->attempt($credentials);
		
		if (! $loginAttempt->isOK()) {
			return redirect()->back()->with('error', $loginAttempt->reason());
		}

		return redirect('/'); */
                
                
                
                $request = service('request');
                
                $user_name=$request->getPost('email');
		$password=$request->getPost('password');
                
                $rules = [
                    'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
                    'password' => ['label' => 'Password', 'rules' => 'required'],
                ];
                
		
                
		$data=array();
                
                
                $this->validation->setRules($rules);
                if(!$this->validation->run($_POST))
                {
                    $this->session->setFlashdata('error', $this->validation->getErrors());

                    redirect('/');
                    return redirect()->to(base_url()); 
                    //redirect(base_url().'public/user_reg');
                    exit;
                }
                
                
                
		
                if($res = $this->loginModel->validate1($user_name,$password))
                {
                        $this->session->set($res);
                         $mtype=$this->session->get('utype');
                        
                        $this->loginModel->online_status($user_name,1);  //update online status
                        $this->loginModel->last_login($user_name); //update last login time

                        if($mtype!='101' && $mtype!='102')
                        {
                                return redirect()->to(base_url().'/member/dashboard');
                        }
                        else
                        {
                                if($mtype=='101')
                                {
                                        return redirect()->to(base_url().'/admin/dashboard');
                                }
                                else
                                {
                                        return redirect()->to(base_url().'/admin/question_bank');
                                }
                        }
                }
                else
                {
                        return redirect()->to(base_url());
                }
		
                
    }

}
