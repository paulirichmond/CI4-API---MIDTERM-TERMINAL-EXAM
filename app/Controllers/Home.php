<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();

        // Count students — covers both role systems
        $totalStudents = $db->table('users u')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->groupStart()
                ->where('r.name', 'student')
                ->orWhere('ur.role_name', 'student')
            ->groupEnd()
            ->countAllResults();

        $activeToday = $db->table('users u')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->groupStart()
                ->where('r.name', 'student')
                ->orWhere('ur.role_name', 'student')
            ->groupEnd()
            ->where('DATE(u.updated_at)', date('Y-m-d'))
            ->countAllResults();

        $newThisMonth = $db->table('users u')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->groupStart()
                ->where('r.name', 'student')
                ->orWhere('ur.role_name', 'student')
            ->groupEnd()
            ->where('MONTH(u.created_at)', date('m'))
            ->where('YEAR(u.created_at)', date('Y'))
            ->countAllResults();

        $courses = $db->table('users')
            ->select('course')
            ->where('course IS NOT NULL', null, false)
            ->where('course !=', '')
            ->groupBy('course')
            ->get()->getNumRows();

        // Count each role (account for both `roles` and legacy `user_role` tables)
        $countTeachers = $db->table('users u')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->groupStart()
                ->where('r.name', 'teacher')
                ->orWhere('ur.role_name', 'teacher')
            ->groupEnd()
            ->countAllResults();

        $countCoords = $db->table('users u')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->groupStart()
                ->where('r.name', 'coordinator')
                ->orWhere('ur.role_name', 'coordinator')
            ->groupEnd()
            ->countAllResults();

        $countAdmins = $db->table('users u')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->groupStart()
                ->where('r.name', 'admin')
                ->orWhere('ur.role_name', 'admin')
            ->groupEnd()
            ->countAllResults();

        // Recent students
        $recentStudents = $db->table('users u')
            ->select('u.id, u.fullname, u.username, u.course, u.year_level, u.created_at')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('user_role ur', 'ur.id = u.role', 'left')
            ->groupStart()
                ->where('r.name', 'student')
                ->orWhere('ur.role_name', 'student')
            ->groupEnd()
            ->orderBy('u.created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('pages/commons/dashboard', array_merge($this->data, [
            'title'          => 'Dashboard',
            'totalStudents'  => $totalStudents,
            'activeToday'    => $activeToday,
            'newThisMonth'   => $newThisMonth,
            'courses'        => $courses,
            'countTeachers'  => $countTeachers,
            'countCoords'    => $countCoords,
            'countAdmins'    => $countAdmins,
            'recentStudents' => $recentStudents,
        ]));
    }

    public function dashboardV2(): string
    {
        return view('pages/commons/dashboard_v2', array_merge($this->data, ['title' => 'Dashboard v2']));
    }

    public function dashboardV3(): string
    {
        return view('pages/commons/dashboard_v3', array_merge($this->data, ['title' => 'Dashboard v3']));
    }
}
