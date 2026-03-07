<?php
namespace App\Services;
use App\Traits\ConsumesExternalService;
class User1Service {
	use ConsumesExternalService;

	/**
	 * The base uri to consume the User1 Service
	 * @var string
	 */
	public $baseUri;

	/**
	 * The secret to consume the User1 Service
	 * @var string
	 */
	public $secret;

	public function __construct()
	{
		$this->baseUri = config('services.users1.base_uri') 
		?: env('USERS1_SERVICE_BASE_URL');
		$this->secret = config('services.users1.secret');
	}


	/**
	 * Obtain the full list of Users from User1 Site
	 * @return string
	 */
	public function obtainUsers1()
	{
		return $this->performRequest('GET', '/users');
	}

	/**
	 * Create one user using the User1 service
	 * @param array $data
	 * @return string
	 */
	public function createUser1($data)
	{
		$response = $this->performRequest('POST', '/users', $data);
		// Ensure the gateway adds which site handled the creation
		$decoded = json_decode($response, true);
		if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
			$decoded['site'] = 1;
			return json_encode($decoded);
		}
		// If response is not JSON, return a JSON string with site info
		return json_encode(['data' => $response, 'site' => 1]);
	}

	/**
	 * Obtain one single user from the User1 service
	 * @param int $id
	 * @return string
	 */
	public function obtainUser1($id)
	{
		return $this->performRequest('GET', "/users/{$id}");
	}

	/**
	 * Update an instance of user1 using the User1 service
	 * @param array $data
	 * @param int $id
	 * @return string
	 */
	public function editUser1($data, $id)
	{
		return $this->performRequest('PUT', "/users/{$id}", $data);
	}

	/**
	 * Remove an existing user
	 * @param int $id
	 * @return string
	 */
	public function deleteUser1($id)
	{
		return $this->performRequest('DELETE', "/users/{$id}");
	}
}