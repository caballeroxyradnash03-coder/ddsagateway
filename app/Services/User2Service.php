<?php
namespace App\Services;
use App\Traits\ConsumesExternalService;
class User2Service{
	use ConsumesExternalService;

	/**
	 * The base uri to consume the User2 Service
	 * @var string
	 */
	public $baseUri;

	/**
	 * The secret to consume the User2 Service
	 * @var string
	 */
	public $secret;

	public function __construct()
	{
		$this->baseUri = config('services.users2.base_uri') 
		?: env('USERS2_SERVICE_BASE_URL');
		$this->secret = config('services.users2.secret');
	}

	/**
	 * Obtain the full list of Users from User2 Site
	 * @return string
	 */
	public function obtainUsers2()
	{
		return $this->performRequest('GET', '/users');
	}

	/**
	 * Obtain one single user from the User2 service
	 * @param int $id
	 * @return string
	 */
	public function obtainUser2($id)
	{
		return $this->performRequest('GET', "/users/{$id}");
	}

	/**
	 * Create one user using the User2 service
	 * @param array $data
	 * @return string
	 */
	public function createUser2($data)
	{
		$response = $this->performRequest('POST', '/users', $data);
		$decoded = json_decode($response, true);
		if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
			$decoded['site'] = 2;
			return json_encode($decoded);
		}
		return json_encode(['data' => $response, 'site' => 2]);
	}

	/**
	 * Update an instance of user2 using the User2 service
	 * @param array $data
	 * @param int $id
	 * @return string
	 */
	public function editUser2($data, $id)
	{
		return $this->performRequest('PUT', "/users/{$id}", $data);
	}

	/**
	 * Remove an existing user
	 * @param int $id
	 * @return string
	 */
	public function deleteUser2($id)
	{
		return $this->performRequest('DELETE', "/users/{$id}");
	}
}