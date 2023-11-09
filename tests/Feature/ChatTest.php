<?php

use App\Models\Agent;
use App\Models\Conversation;
use App\Models\User;

test('user can create a conversation', function() {
  $user = User::factory()->create();
  $this->actingAs($user);

  $user->agents()->create();

  $this->assertCount(0, Conversation::all());

  $response = $this->postJson(route('conversations.store'), [
    'agent_id' => Agent::first()->id,
  ]);

  $this->assertCount(1, Conversation::all());
});

test('user must send agent_id when creating conversation', function() {
  $user = User::factory()->create();
  $this->actingAs($user);

  $user->agents()->create();

  $this->assertCount(0, Conversation::all());

  $response = $this->postJson(route('conversations.store'), [
    // 'agent_id' => Agent::first()->id,
  ]);

  $response->assertStatus(422);
  $this->assertCount(0, Conversation::all());
});

// 3. user can send a message
// 4. agent can send a message
