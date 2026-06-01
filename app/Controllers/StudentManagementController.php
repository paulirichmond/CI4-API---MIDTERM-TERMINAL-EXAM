<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * StudentManagementController
 *
 * Lists all student accounts for teacher/admin view.
 * Protected by: ['auth', 'teacher']
 */
class StudentManagementController extends BaseController
{
    protected UserModel $userModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->userModel = new UserModel();
    }

    /** List all users whose role is 'student'. */
    public function index()
    {
        $students = $this->db->table('users u')
            ->select('u.id, u.fullname AS name, u.username AS email, u.student_id,
                      u.course, u.year_level, u.section, u.created_at, u.profile_image')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->groupStart()
                ->where('r.name', 'student')
                ->orWhere('ur.role_name', 'student')
            ->groupEnd()
            ->orderBy('u.fullname', 'ASC')
            ->get()->getResultArray();

        return view('teacher/students', array_merge($this->data, [
            'title'    => 'Student Management',
            'students' => $students,
        ]));
    }

    /** Show a single student's profile (read-only for teachers). */
    public function show(int $id)
    {
        $student = $this->db->table('users u')
            ->select('u.*, ur.role_name')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->where('u.id', $id)
            ->get()->getRowArray();

        if (! $student) {
            session()->setFlashdata('notif_error', 'Student not found.');
            return redirect()->to('/students');
        }

        // Restrict teachers from viewing admin profiles
        $currentRole = strtolower(session('user')['role'] ?? session('user')['role_name'] ?? '');
        $viewedRole  = strtolower($student['role_name'] ?? '');
        if ($currentRole === 'teacher' && $viewedRole === 'admin') {
            // Return a 403 Forbidden with a clear message
            $message = 'You are currently logged in as a teacher. This account does not have the necessary permissions to view this system segment.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message, 'userRole' => 'teacher']));
        }

        return view('teacher/student_show', array_merge($this->data, [
            'title'   => 'Student Profile',
            'student' => $student,
        ]));
    }

    public function edit(int $id)
    {
        $student = $this->db->table('users u')
            ->select('u.*, ur.role_name')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->where('u.id', $id)
            ->where('ur.role_name', 'student')
            ->get()->getRowArray();

        if (! $student) {
            session()->setFlashdata('notif_error', 'Student not found.');
            return redirect()->to('/students');
        }

        $currentRole = strtolower(session('user')['role'] ?? '');
        if (! in_array($currentRole, ['admin', 'teacher', 'coordinator'], true)) {
            return redirect()->to('/unauthorized');
        }

        if ($currentRole === 'teacher' && strtolower($student['role_name'] ?? '') === 'admin') {
            $message = 'You are currently logged in as a teacher. This account does not have the necessary permissions to edit this student profile.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message, 'userRole' => 'teacher']));
        }

        return view('teacher/student_edit', array_merge($this->data, [
            'title'   => 'Edit Student',
            'student' => $student,
        ]));
    }

    public function update(int $id)
    {
        $student = $this->db->table('users u')
            ->select('u.*, ur.role_name')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->where('u.id', $id)
            ->where('ur.role_name', 'student')
            ->get()->getRowArray();

        if (! $student) {
            session()->setFlashdata('notif_error', 'Student not found.');
            return redirect()->to('/students');
        }

        $currentRole = strtolower(session('user')['role'] ?? '');
        if (! in_array($currentRole, ['admin', 'teacher', 'coordinator'], true)) {
            return redirect()->to('/unauthorized');
        }

        $data = [
            'fullname'   => $this->request->getPost('fullname'),
            'username'   => $this->request->getPost('username'),
            'student_id' => $this->request->getPost('student_id'),
            'course'     => $this->request->getPost('course'),
            'year_level' => $this->request->getPost('year_level'),
            'section'    => $this->request->getPost('section'),
            'phone'      => $this->request->getPost('phone'),
            'address'    => $this->request->getPost('address'),
        ];

        $this->db->table('users')->where('id', $id)->update($data);

        session()->setFlashdata('notif_success', 'Student profile updated successfully.');
        return redirect()->to('/students');
    }
}
