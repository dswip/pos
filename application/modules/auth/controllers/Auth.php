<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'member/member_model'
		]);
	}

	/* Member Authentication */
	public function member_post()
	{
		$this->form_validation->set_rules('identity', 'identity', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		$this->form_validation->set_data($this->post());
		if ($this->form_validation->run() == TRUE)
		{
			$find = $this->member->where([
				['email','=',$this->post('identity')],
				['password','=',$this->post('password')]
			])->first();
			if(!empty($find))
			{
				$response = 
				[
					'status' => 'successs',
					'data' => 
					[
						'token' => $this->security->jwt_encode([
							'member_id' => $find->id,
							'first_name' => $find->first_name,
							'type' => $find->type,
							'email' => $find->email
						])
					]
				];
			}
			else
			{
				$response = 
				[
					'status' => 'failed',
					'message_code' => 'data_not_found',
					'message' => site_language('data_not_found','data not found')
				];
			}
		}
		else
		{
			$validation_errors = explode('<p>',str_replace('</p>','',validation_errors()));
			array_shift($validation_errors);
			$response = 
			[
				'status' => 'failed',
				'message_code' => 'validation_error',
				'message' => site_language('validation_error','validation error'),
				'data' => $validation_errors
			];
		}
		$this->response($response,REST_Controller::HTTP_OK);
	}
}

/* End of file Auth.php */
/* Location: ./application/modules/auth/controllers/Auth.php */