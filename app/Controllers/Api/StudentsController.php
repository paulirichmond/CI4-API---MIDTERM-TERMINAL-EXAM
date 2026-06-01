<?php

namespace App\Controllers\Api;

use App\Models\UserModel;

class StudentsController extends BaseApiController
{
    private UserModel $userModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (! $this->hasTeacherAccess()) {
            return $this->forbidden('Only teachers and admins can list students.');
        }

        $students = array_map([$this, 'sanitize'], $this->userModel->getStudents());
        return $this->ok($students);
    }

    public function show(int $id)
    {
        if (! $this->hasTeacherAccess()) {
            return $this->forbidden('Only teachers and admins can view student profiles.');
        }

        $student = $this->userModel->getStudentById($id);

        if (! $student) {
            return $this->notFound("Student #{$id} not found.");
        }

        return $this->ok($this->sanitize($student));
    }

    public function profile()
    {
        if (! $this->apiUser) {
            return $this->forbidden('User data not available.');
        }

        $profile = $this->apiUser;
        unset($profile['token'], $profile['expires_at'], $profile['created_at'], $profile['updated_at'], $profile['user_id']);
        unset($profile['id'], $profile['password']);

        // Ensure we expose the authenticated user record fields cleanly.
        return $this->ok([ 
            'id'         => $this->apiUser['user_id'] ?? null,
            'fullname'   => $this->apiUser['fullname'] ?? null,
            'username'   => $this->apiUser['username'] ?? null,
            'student_id' => $this->apiUser['student_id'] ?? null,
            'course'     => $this->apiUser['course'] ?? null,
            'year_level' => $this->apiUser['year_level'] ?? null,
            'section'    => $this->apiUser['section'] ?? null,
            'phone'      => $this->apiUser['phone'] ?? null,
            'address'    => $this->apiUser['address'] ?? null,
            'profile_image' => $this->apiUser['profile_image'] ?? null,
            'role_name'  => $this->apiUser['role_name'] ?? null,
            'created_at' => $this->apiUser['created_at'] ?? null,
        ]);
    }

    private function hasTeacherAccess(): bool
    {
        return $this->apiUser && in_array($this->apiUser['role_name'], ['teacher', 'admin'], true);
    }

    private function sanitize(array $row): array
    {
        unset($row['password']);
        return $row;
    }
}
