<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

/**
 * UserAdminController  (Admin\UserAdminController)
 *
 * Allows admin to view all users and assign/change their roles.
 * Protected by: ['auth', 'admin']
 */
class UserAdminController extends BaseController
{
    protected UserModel $userModel;
    protected RoleModel $roleModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    /** List all users with their current role and a dropdown to change it. */
    public function index()
    {
        return view('admin/users/index', array_merge($this->data, [
            'title' => 'User Role Assignment',
            'users' => $this->userModel->getAllWithRoles(),
            'roles' => $this->roleModel->getDropdown(), // id => label map for <select>
        ]));
    }

    /** Assign a role to a specific user (POST). */
    public function assignRole(int $userId)
    {
        $user   = $this->userModel->find($userId);
        $roleId = (int) $this->request->getPost('role_id');
        $role   = $this->roleModel->find($roleId);

        if (! $user || ! $role) {
            session()->setFlashdata('error', 'User or role not found.');
            return redirect()->to('/admin/users');
        }

        // Prevent admin from removing their own admin role
        if ($user['id'] === (session('user')['id'] ?? 0) && $role['name'] !== 'admin') {
            session()->setFlashdata('error', 'You cannot change your own admin role.');
            return redirect()->to('/admin/users');
        }

        $this->userModel->update($userId, ['role_id' => $roleId]);

        session()->setFlashdata('success',
            esc($user['fullname']) . ' has been assigned the role: ' . esc($role['label'])
        );
        return redirect()->to('/admin/users');
    }

    /** Show edit form for arbitrary user (admin only). */
    public function edit(int $userId)
    {
        $user = $this->userModel->findWithRole($userId);
        if (! $user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }
        // Prevent admin self-edit: if the target is the current user and is an admin, return 403
        $currentUserId = (int) (session('user')['id'] ?? session('user')['userID'] ?? 0);
        if (($user['role_name'] ?? '') === 'admin' && (int) $user['id'] === $currentUserId) {
            $message = 'You are currently logged in as a teacher. This account does not have the necessary permissions to view this system segment.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message]));
        }
        // Prevent teachers from editing admin accounts — return 403 for clarity
        $currentRole = strtolower(session('user')['role'] ?? '');
        if (($user['role_name'] ?? '') === 'admin' && $currentRole === 'teacher') {
            $message = 'You are currently logged in as a teacher. This account does not have the necessary permissions to view this system segment.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message]));
        }
        // Other non-admin roles will be redirected with a flash message
        if (($user['role_name'] ?? '') === 'admin' && $currentRole !== 'admin') {
            session()->setFlashdata('error', 'You do not have permission to edit this account.');
            return redirect()->to('/admin/users');
        }

        return view('admin/users/edit', array_merge($this->data, [
            'title' => 'Edit User',
            'user'  => $user,
            'roles' => $this->roleModel->getDropdown(),
        ]));
    }

    /** Update arbitrary user profile (admin only). */
    public function update(int $userId)
    {
        $user = $this->userModel->find($userId);
        if (! $user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }
        // Prevent admin self-update: if the target is the current user and is an admin, return 403
        $target = $this->userModel->findWithRole($userId);
        $currentRole = strtolower(session('user')['role'] ?? '');
        $currentUserId = (int) (session('user')['id'] ?? session('user')['userID'] ?? 0);
        if (($target['role_name'] ?? '') === 'admin' && (int) $target['id'] === $currentUserId) {
            $message = 'You are currently logged in as a teacher. This account does not have the necessary permissions to view this system segment.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message]));
        }
        // Prevent teachers from updating admin accounts — return 403 for clarity
        if (($target['role_name'] ?? '') === 'admin' && $currentRole === 'teacher') {
            $message = 'You are currently logged in as a teacher. This account does not have the necessary permissions to view this system segment.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message]));
        }
        // Other non-admin roles will be redirected with a flash message
        if (($target['role_name'] ?? '') === 'admin' && $currentRole !== 'admin') {
            session()->setFlashdata('error', 'You do not have permission to update this account.');
            return redirect()->to('/admin/users');
        }

        $data = [
            'fullname' => $this->request->getPost('fullname'),
            'username' => $this->request->getPost('username'),
            'phone'    => $this->request->getPost('phone'),
            'address'  => $this->request->getPost('address'),
        ];

        $newPassword = $this->request->getPost('new_password');
        if (! empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // profile image handling
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if ($this->validate(['profile_image' => 'is_image[profile_image]|max_size[profile_image,2048]'])) {
                if (! empty($user['profile_image'])) {
                    $old = FCPATH . 'uploads/profiles/' . $user['profile_image'];
                    if (file_exists($old)) unlink($old);
                }
                $ext = $file->getExtension();
                $newName = 'avatar_' . $userId . '_' . time() . '.' . $ext;
                $file->move(FCPATH . 'uploads/profiles/', $newName);
                $data['profile_image'] = $newName;
            }
        }

        $this->userModel->updateProfile($userId, $data);

        session()->setFlashdata('success', 'User profile updated successfully.');
        return redirect()->to('/admin/users');
    }
}
