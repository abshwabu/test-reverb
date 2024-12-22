<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Cache;
use App\Events\SwitchFlipped;
use Livewire\Attributes\On;
new class extends Component {
    public $toggleSwitch;
    
    public function mount()
    {
        $this->toggleSwitch = Cache::get('toggleSwitch', false);
    }

    public function flipSwitch()
    {
        // $this->toggleSwitch = !$this->toggleSwitch;
        Cache::forever('toggleSwitch', $this->toggleSwitch);
        broadcast(new SwitchFlipped($this->toggleSwitch));
    }

    #[On('echo:switch, SwitchFlipped')]
    public function registerSwitch($event)
    {
        $this->toggleSwitch = $event['toggleSwitch'];
        Cache::forever('toggleSwitch', $this->toggleSwitch);
    }

}; ?>

<div x-data="{
    localToggle: @entangle('toggleSwitch'),
    
}">
    <div class="flex items-center justify-center min-h-screen">
        <label for="toggleSwitch" class="flex items-center">
            <div class="relative">
                <input type="checkbox" id="toggleSwitch" class="sr-only" x-model="localToggle"
                    x-on:change="$wire.flipSwitch()">
                <div class="block h-8 bg-gray-600 rounded-full w-14"></div>
                <div class="absolute w-6 h-6 transition-transform duration-200 rounded-full left-1 top-1"
                    x-bind:class="localToggle ? 'translate-x-full bg-green-400' : 'bg-white'">
                </div>
            </div>
        </label>
    </div>
</div>
</div>