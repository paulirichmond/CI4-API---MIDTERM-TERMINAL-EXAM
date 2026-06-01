<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampleAccounts extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // ── STUDENTS (role_id=3, role=3) ──────────────────────────────
        $students = [
            ['Maria Santos',       'maria.santos@digimon.edu',       'BSIT',  '1', 'A', '2023-08-15 08:00:00', '2024001'],
            ['Juan dela Cruz',     'juan.delacruz@digimon.edu',      'BSCS',  '2', 'B', '2023-08-15 08:30:00', '2024002'],
            ['Ana Reyes',          'ana.reyes@digimon.edu',          'BSBA',  '1', 'C', '2023-09-01 09:00:00', '2024003'],
            ['Carlo Mendoza',      'carlo.mendoza@digimon.edu',      'BSIT',  '3', 'A', '2023-09-10 10:00:00', '2024004'],
            ['Liza Garcia',        'liza.garcia@digimon.edu',        'BSED',  '2', 'B', '2023-10-05 08:00:00', '2024005'],
            ['Mark Villanueva',    'mark.villanueva@digimon.edu',    'BSHM',  '1', 'A', '2024-01-10 09:00:00', '2024006'],
            ['Sofia Torres',       'sofia.torres@digimon.edu',       'BSCS',  '3', 'C', '2024-01-15 10:00:00', '2024007'],
            ['Ryan Flores',        'ryan.flores@digimon.edu',        'BSIT',  '4', 'B', '2024-02-01 08:00:00', '2024008'],
            ['Jasmine Ramos',      'jasmine.ramos@digimon.edu',      'BSBA',  '2', 'A', '2024-02-14 09:00:00', '2024009'],
            ['Patrick Cruz',       'patrick.cruz@digimon.edu',       'BSED',  '1', 'C', '2024-03-01 08:00:00', '2024010'],
            ['Nicole Bautista',    'nicole.bautista@digimon.edu',    'BSHM',  '3', 'B', '2024-03-20 10:00:00', '2024011'],
            ['Kevin Aquino',       'kevin.aquino@digimon.edu',       'BSIT',  '2', 'A', '2024-04-05 09:00:00', '2024012'],
            ['Trisha Castillo',    'trisha.castillo@digimon.edu',    'BSCS',  '1', 'C', '2024-04-18 08:00:00', '2024013'],
            ['Jerome Navarro',     'jerome.navarro@digimon.edu',     'BSBA',  '4', 'B', '2024-05-02 10:00:00', '2024014'],
            ['Camille Lim',        'camille.lim@digimon.edu',        'BSED',  '3', 'A', '2024-05-20 09:00:00', '2024015'],
        ];

        foreach ($students as [$name, $email, $course, $year, $section, $created, $sid]) {
            $exists = $this->db->table('users')->where('username', $email)->countAllResults();
            if (!$exists) {
                $this->db->table('users')->insert([
                    'fullname'   => $name,
                    'username'   => $email,
                    'password'   => password_hash('student123', PASSWORD_DEFAULT),
                    'role'       => 3,
                    'role_id'    => 3,
                    'student_id' => $sid,
                    'course'     => $course,
                    'year_level' => $year,
                    'section'    => $section,
                    'created_at' => $created,
                    'updated_at' => $created,
                ]);
            }
        }

        // ── TEACHERS (role_id=2, role=2) ──────────────────────────────
        $teachers = [
            ['Prof. Jose Rizal',    'jose.rizal@digimon.edu',    'teacher123'],
            ['Prof. Andres Bonifacio', 'andres.bonifacio@digimon.edu', 'teacher123'],
            ['Prof. Emilio Aguinaldo', 'emilio.aguinaldo@digimon.edu', 'teacher123'],
        ];

        foreach ($teachers as [$name, $email, $pass]) {
            $exists = $this->db->table('users')->where('username', $email)->countAllResults();
            if (!$exists) {
                $this->db->table('users')->insert([
                    'fullname'   => $name,
                    'username'   => $email,
                    'password'   => password_hash($pass, PASSWORD_DEFAULT),
                    'role'       => 2,
                    'role_id'    => 2,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // ── COORDINATORS (role_id=4, role=4) ──────────────────────────
        $coordinators = [
            ['Coord. Maria Clara',  'maria.clara@digimon.edu',  'coord123'],
            ['Coord. Sisa Reyes',   'sisa.reyes@digimon.edu',   'coord123'],
        ];

        foreach ($coordinators as [$name, $email, $pass]) {
            $exists = $this->db->table('users')->where('username', $email)->countAllResults();
            if (!$exists) {
                $this->db->table('users')->insert([
                    'fullname'   => $name,
                    'username'   => $email,
                    'password'   => password_hash($pass, PASSWORD_DEFAULT),
                    'role'       => 4,
                    'role_id'    => 4,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // ── ADMIN (role_id=1, role=1) ──────────────────────────────────
        $admins = [
            ['System Admin',  'sysadmin@digimon.edu',  'admin123'],
        ];

        foreach ($admins as [$name, $email, $pass]) {
            $exists = $this->db->table('users')->where('username', $email)->countAllResults();
            if (!$exists) {
                $this->db->table('users')->insert([
                    'fullname'   => $name,
                    'username'   => $email,
                    'password'   => password_hash($pass, PASSWORD_DEFAULT),
                    'role'       => 1,
                    'role_id'    => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        echo "Sample accounts seeded successfully!\n";
        echo "- 15 Students (password: student123)\n";
        echo "- 3 Teachers  (password: teacher123)\n";
        echo "- 2 Coordinators (password: coord123)\n";
        echo "- 1 Admin     (password: admin123)\n";
    }
}
