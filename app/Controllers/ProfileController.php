<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function show()
    {
        $user = $this->data['user'];

        if (! $user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        // Prevent admin from viewing/editing their own profile via profile routes
        $currentRole = strtolower(session('user')['role'] ?? session('user')['role_name'] ?? '');
        if ($currentRole === 'admin') {
            $message = 'You are currently logged in as an administrator. This account does not have the necessary permissions to view this system segment.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message, 'userRole' => 'admin']));
        }

        return view('profile/show', array_merge($this->data, ['user' => $user]));
    }

    public function edit()
    {
        $user = $this->data['user'];

        // Prevent admin from editing their profile via profile routes
        $currentRole = strtolower(session('user')['role'] ?? session('user')['role_name'] ?? '');
        if ($currentRole === 'admin') {
            $message = 'You are currently logged in as an administrator. This account does not have the necessary permissions to view this system segment.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message, 'userRole' => 'admin']));
        }

        return view('profile/edit', array_merge($this->data, ['user' => $user]));
    }

    public function update()
    {
        $user   = $this->data['user'];
        // Prevent admin from updating their profile via profile routes
        $currentRole = strtolower(session('user')['role'] ?? session('user')['role_name'] ?? '');
        $currentUserId = (int) (session('user')['id'] ?? session('user')['userID'] ?? 0);
        if ($currentRole === 'admin' && ((int) ($user['id'] ?? 0) === $currentUserId)) {
            $message = 'You are currently logged in as an administrator. This account does not have the necessary permissions to view this system segment.';
            return $this->response->setStatusCode(403)->setBody(view('errors/html/error_403', ['message' => $message, 'userRole' => 'admin']));
        }
        // Resolve the numeric user id from possible shapes (userID, id, or session values)
        $userId = $user['userID'] ?? $user['id'] ?? session('user.userID') ?? session('user.id') ?? session('id') ?? null;
        // Ensure an integer or null
        $userId = $userId ? (int) $userId : null;
        $userModel = new UserModel();

        // Validate text fields
        $rules = [
            'fullname'         => 'required|min_length[3]',
            // Trim username and ignore current user's id when checking uniqueness
            'username'         => 'required|trim|is_unique[users.username,id,' . ($userId ?? '') . ']',
            'student_id'       => 'permit_empty|max_length[20]',
            'course'           => 'permit_empty|max_length[100]',
            'year_level'       => 'permit_empty|integer|greater_than[0]|less_than[6]',
            'section'          => 'permit_empty|max_length[50]',
            'phone'            => 'permit_empty|max_length[20]',
            'address'          => 'permit_empty|max_length[255]',
            'new_password'     => 'permit_empty|min_length[8]',
            'confirm_password' => 'permit_empty|matches[new_password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'fullname'   => $this->request->getPost('fullname'),
            'username'   => $this->request->getPost('username'),
            'student_id' => $this->request->getPost('student_id'),
            'course'     => $this->request->getPost('course'),
            'year_level' => $this->request->getPost('year_level'),
            'section'    => $this->request->getPost('section'),
            'phone'      => $this->request->getPost('phone'),
            'address'    => $this->request->getPost('address'),
        ];

        // Handle password change
        $newPassword = $this->request->getPost('new_password');
        if (! empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Handle image upload
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if ($this->validate([
                'profile_image' => 'is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png,image/webp]|max_size[profile_image,2048]',
            ])) {
                // Delete old image
                if (! empty($user['profile_image'])) {
                    $old = FCPATH . 'uploads/profiles/' . $user['profile_image'];
                    if (file_exists($old)) unlink($old);
                }

                $ext     = $file->getExtension();
                $newName = 'avatar_' . $userId . '_' . time() . '.' . $ext;
                $file->move(FCPATH . 'uploads/profiles/', $newName);
                $updateData['profile_image'] = $newName;
            }
        }

        $userModel->updateProfile($userId, $updateData);

        // Refresh session so navbar name updates immediately
        $sessionUser = session('user');
        if ($sessionUser) {
            $sessionUser['name']     = $updateData['fullname'];
            $sessionUser['fullname'] = $updateData['fullname'];
            $sessionUser['username'] = $updateData['username'];
            $sessionUser['email']    = $updateData['username'];
            session()->set('user', $sessionUser);
        }
        session()->set('username', $updateData['username']);

        session()->setFlashdata('success', 'Profile updated successfully!');
        return redirect()->to('/profile');
    }
}
