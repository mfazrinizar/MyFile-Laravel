<?php

namespace Illuminate\Contracts\Auth;

interface Guard
{
    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    public function user();

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id();
}

interface StatefulGuard
{
    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    public function user();

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id();
}

interface Factory
{
    /**
     * Get the currently authenticated user.
     *
     * @return \App\Models\User|null
     */
    public function user();

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id();
}