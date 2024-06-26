<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\Htmx\ChatController;
use App\Http\Controllers\Htmx\ThreadController;
use App\Http\Controllers\NostrAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\Webhook\PoolWebhookReceiver;
use App\Livewire\Admin;
use App\Livewire\Agents\Create;
use App\Livewire\Agents\Edit;
use App\Livewire\Agents\Index;
use App\Livewire\Agents\Profile;
use App\Livewire\Blog;
use App\Livewire\Changelog;
use App\Livewire\Chat;
use App\Livewire\IndexedCodebaseList;
use App\Livewire\Logs;
use App\Livewire\MarkdownPage;
use App\Livewire\ProWelcome;
use App\Livewire\Settings;
use App\Livewire\Store;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// HOME
Route::get('/', function () {
    return redirect()->route('chat');
})->name('home');

// CHAT
Route::get('/chat', Chat::class)->name('chat');
Route::get('/chat/{id}', Chat::class)->name('chat.id');
Route::get('/chatmx', [ChatController::class, 'index']);

// AGENTS
Route::get('/agents', Index::class)->name('agents');
Route::get('/create', Create::class)->name('agents.create');
Route::get('/agents/{agent}', Profile::class)->name('agents.profile');
Route::get('/agents/{agent}/edit', Edit::class)->name('agents.edit');

// PROFILES
Route::get('/u/{username}', [ProfileController::class, 'show'])->name('profile');

// STORE
Route::get('/store', Store::class)->name('store');

// THREADS
Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/chatmx/{thread}', [ThreadController::class, 'show'])->name('threads.show');

Route::middleware('guest')->group(function () {
    // AUTH - SOCIAL
    Route::get('/login/x', [SocialAuthController::class, 'login_x']);
    Route::get('/callback/x', [SocialAuthController::class, 'login_x_callback']);
});

// AUTH - NOSTR
Route::get('/login/nostr', [NostrAuthController::class, 'client'])->name('loginnostrclient');
Route::post('/login/nostr', [NostrAuthController::class, 'create'])->name('loginnostr');

// SETTINGS
Route::get('/settings', Settings::class)->name('settings');

// BILLING
Route::get('/subscription', [BillingController::class, 'stripe_billing_portal']);
Route::get('/upgrade', [BillingController::class, 'stripe_subscribe']);
Route::get('/pro', ProWelcome::class)->name('pro');

// CODEBASE INDEXES
Route::get('/codebases', IndexedCodebaseList::class);

// PLUGIN REGISTRY
Route::get('/plugins', [StaticController::class, 'plugins']);

// BLOG
Route::get('/blog', Blog::class);
Route::get('/launch', MarkdownPage::class);
Route::get('/goodbye-chatgpt', MarkdownPage::class);
Route::get('/introducing-the-agent-store', MarkdownPage::class);

// LANDERS
Route::get('/campaign/{id}', [CampaignController::class, 'land']);

// MISC
Route::get('/changelog', Changelog::class);
Route::get('/docs', function () {
    return redirect('https://docs.openagents.com');
});
Route::get('/terms', MarkdownPage::class);
Route::get('/privacy', MarkdownPage::class);

// ADMIN
Route::get('/admin', Admin::class)->name('admin');
Route::get('/logs', Logs::class)->name('logs');

// Nostr Webhook
Route::post('/webhook/nostr', [PoolWebhookReceiver::class, 'handleEvent']);

// Logout via GET not just POST
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);

// Catch-all redirect to the homepage
Route::get('/{any}', function () {
    return redirect('/');
})->where('any', '.*');
