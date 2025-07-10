<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get('/marketplace');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the marketplace', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/marketplace');
    $response->assertStatus(200);
});
