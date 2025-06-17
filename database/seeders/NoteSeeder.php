<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Merchant;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $merchants = Merchant::all();

        $sampleNotes = [
            [
                'title' => 'Initial Contact',
                'content' => 'First meeting went well. Discussed pricing and service requirements.',
                'priority' => 'medium'
            ],
            [
                'title' => 'Payment Issue',
                'content' => 'Late payment on invoice #1234. Sent reminder email.',
                'priority' => 'high'
            ],
            [
                'title' => 'Service Upgrade',
                'content' => 'Client interested in premium package. Schedule follow-up call.',
                'priority' => 'low'
            ],
            [
                'title' => 'Contract Renewal',
                'content' => 'Contract expires next month. Need to prepare renewal proposal.',
                'priority' => 'high'
            ],
            [
                'title' => 'Support Request',
                'content' => 'Client reported technical issues. Escalated to technical team.',
                'priority' => 'medium'
            ],
            [
                'title' => 'Feedback Session',
                'content' => 'Positive feedback on recent service delivery. Client very satisfied.',
                'priority' => 'low'
            ]
        ];

        foreach ($merchants as $merchant) {
            // Create 2-4 random notes for each merchant
            $notesToCreate = rand(2, 4);
            $selectedNotes = collect($sampleNotes)->random($notesToCreate);

            foreach ($selectedNotes as $noteData) {
                Note::create([
                    'merchant_id' => $merchant->id,
                    'title' => $noteData['title'],
                    'content' => $noteData['content'],
                    'priority' => $noteData['priority']
                ]);
            }
        }
    }
}