@section('title', 'Raheela Adventure')

@push('styles')
<style>
    /* Premium Glassmorphism UI */
    .glass-panel {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    }
    
    .glass-btn {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .glass-btn:active {
        transform: scale(0.95);
        background: rgba(255, 255, 255, 0.1);
    }

    .premium-gradient {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    }

    .premium-gradient-text {
        background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Ambient animated background */
    .ambient-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        background: #0f172a;
    }
    .ambient-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.5;
        animation: float 20s infinite ease-in-out alternate;
    }
    .blob-1 { top: -10%; left: -10%; width: 300px; height: 300px; background: #3b82f6; animation-delay: 0s; }
    .blob-2 { bottom: -10%; right: -10%; width: 300px; height: 300px; background: #8b5cf6; animation-delay: -5s; }
    .blob-3 { top: 40%; left: 50%; width: 250px; height: 250px; background: #ec4899; animation-delay: -10s; }

    @keyframes float {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(30px, -50px) scale(1.1); }
        100% { transform: translate(-20px, 30px) scale(0.9); }
    }

    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

<div class="h-full w-full flex flex-col relative" x-data="{ showHelp: false, showLeaderboard: false }">
    
    {{-- Ambient Background --}}
    <div class="ambient-bg pointer-events-none">
        <div class="ambient-blob blob-1"></div>
        <div class="ambient-blob blob-2"></div>
        <div class="ambient-blob blob-3"></div>
    </div>

    {{-- Top Navigation Bar --}}
    <div class="relative z-20 flex justify-between items-center p-4">
        <div class="flex items-center gap-3">
            <a href="/" class="w-10 h-10 rounded-full premium-gradient flex items-center justify-center shadow-lg shadow-blue-500/30 text-white hover:scale-105 transition-transform" title="Kembali ke Beranda">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
            </a>
            @if(in_array($step, ['quiz', 'flight', 'wordle', 'match']))
            <button wire:click="resetGame" class="w-10 h-10 rounded-full glass-btn flex items-center justify-center text-white hover:scale-105 transition-transform" title="Kembali ke Pilihan Game">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </button>
            @endif
            @if($step !== 'menu')
            <div class="flex flex-col ml-1">
                <span class="text-xs text-slate-400 font-medium tracking-wide uppercase">Pemain</span>
                <span class="text-sm text-white font-bold truncate max-w-[120px]">{{ $playerName }}</span>
            </div>
            @endif
        </div>
        
        <div class="flex items-center gap-2">
            @if($step !== 'menu' && $step !== 'result')
            <div class="glass-panel px-3 py-1.5 rounded-full flex items-center gap-2 mr-2">
                <span class="text-sm">⭐</span>
                <span class="text-sm font-bold text-white">{{ $score }}</span>
            </div>
            @endif
            
            <button @click="showHelp = true" class="w-10 h-10 rounded-full glass-btn flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </button>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="relative z-10 flex-1 overflow-y-auto no-scrollbar pb-6 px-4 flex flex-col justify-center">
        
        {{-- ============================== --}}
        {{-- STEP: MENU --}}
        {{-- ============================== --}}
        @if($step === 'menu')
        <div class="flex flex-col items-center justify-center h-full space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
            
            <div class="text-center space-y-4">
                <div class="inline-flex p-4 rounded-3xl glass-panel shadow-2xl mb-2 relative">
                    <div class="absolute inset-0 premium-gradient opacity-20 rounded-3xl blur-xl"></div>
                    <span class="text-6xl relative z-10">🚀</span>
                </div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight">Raheela<br/><span class="premium-gradient-text">Adventure</span></h1>
                <p class="text-slate-400 text-sm font-medium">Bermain & Belajar Bersama</p>
            </div>

            <div class="w-full space-y-4 pt-8">
                <div class="relative">
                    <input type="text" wire:model.live="playerName" placeholder="Siapa namamu?" 
                        class="w-full glass-panel border-white/20 text-white rounded-2xl px-5 py-4 text-center text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all placeholder:text-slate-500">
                    @error('playerName') 
                        <span class="absolute -bottom-6 left-0 right-0 text-center text-red-400 text-xs font-medium">{{ $message }}</span>
                    @enderror
                </div>
                
                <button wire:click="goToSelectGame" @disabled(strlen($playerName) < 2) 
                    class="w-full premium-gradient text-white rounded-2xl py-4 font-bold text-lg shadow-lg shadow-blue-500/25 active:scale-[0.98] transition-transform disabled:opacity-50 disabled:pointer-events-none flex items-center justify-center gap-2">
                    Mulai Bermain
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>
        </div>
        @endif

        {{-- ============================== --}}
        {{-- STEP: SELECT GAME --}}
        {{-- ============================== --}}
        @if($step === 'select_game')
        <div class="flex flex-col h-full space-y-6 pt-4 animate-in fade-in slide-in-from-right-8 duration-500">
            <div class="text-left mb-2">
                <h2 class="text-2xl font-bold text-white mb-1">Pilih Misimu</h2>
                <p class="text-sm text-slate-400">Pilih salah satu game untuk dimainkan.</p>
            </div>

            <div class="grid grid-cols-1 gap-4">
                {{-- Quiz Game --}}
                <button wire:click="selectGame('quiz')" class="glass-panel w-full rounded-3xl p-5 flex items-center gap-5 text-left group active:scale-[0.98] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 transition-transform">
                        📚
                    </div>
                    <div class="flex-1">
                        <h3 class="text-white font-bold text-lg">Cerdas Cermat</h3>
                        <p class="text-slate-400 text-xs mt-1 line-clamp-2">Uji pengetahuanmu tentang Sekolah Raheela & agama Islam.</p>
                    </div>
                    <div class="text-slate-500 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </div>
                </button>

                {{-- Flight Game --}}
                <button wire:click="selectGame('flight')" class="glass-panel w-full rounded-3xl p-5 flex items-center gap-5 text-left group active:scale-[0.98] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 transition-transform">
                        ✈️
                    </div>
                    <div class="flex-1">
                        <h3 class="text-white font-bold text-lg">Sekolah Rimba</h3>
                        <p class="text-slate-400 text-xs mt-1 line-clamp-2">Kendalikan pesawat, kumpulkan kebaikan, hindari keburukan.</p>
                    </div>
                    <div class="text-slate-500 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </div>
                </button>

                {{-- Word Search Game --}}
                <button wire:click="selectGame('wordle')" class="glass-panel w-full rounded-3xl p-5 flex items-center gap-5 text-left group active:scale-[0.98] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-green-500/20 border border-green-500/30 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 transition-transform">
                        🔎
                    </div>
                    <div class="flex-1">
                        <h3 class="text-white font-bold text-lg">Cari Kata</h3>
                        <p class="text-slate-400 text-xs mt-1 line-clamp-2">Geser jarimu untuk menemukan kata-kata tersembunyi.</p>
                    </div>
                    <div class="text-slate-500 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </div>
                </button>

                {{-- Memory Match Game --}}
                <button wire:click="selectGame('match')" class="glass-panel w-full rounded-3xl p-5 flex items-center gap-5 text-left group active:scale-[0.98] transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-orange-500/20 border border-orange-500/30 flex items-center justify-center text-3xl shrink-0 group-hover:scale-110 transition-transform">
                        🃏
                    </div>
                    <div class="flex-1">
                        <h3 class="text-white font-bold text-lg">Cocokkan Kartu</h3>
                        <p class="text-slate-400 text-xs mt-1 line-clamp-2">Latih ingatanmu dengan mencocokkan gambar yang sama.</p>
                    </div>
                    <div class="text-slate-500 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </div>
                </button>
            </div>
            
            <button wire:click="backToMenu" class="text-slate-500 text-sm font-medium mt-auto pt-4 pb-2 hover:text-white transition-colors text-center w-full">
                Ganti Pemain
            </button>
        </div>
        @endif

        {{-- ============================== --}}
        {{-- STEP: QUIZ --}}
        {{-- ============================== --}}
        @if($step === 'quiz')
        <div class="flex flex-col h-full animate-in fade-in slide-in-from-right-8 duration-500">
            <div class="mb-6">
                <div class="flex justify-between text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">
                    <span>Pertanyaan {{ $currentQuizIdx + 1 }} dari {{ count($quizData) }}</span>
                </div>
                <div class="w-full bg-slate-800/50 h-2 rounded-full overflow-hidden">
                    <div class="premium-gradient h-full rounded-full transition-all duration-500 ease-out" 
                         style="width: {{ (($currentQuizIdx + 1) / max(count($quizData), 1)) * 100 }}%"></div>
                </div>
            </div>

            <div class="glass-panel rounded-3xl p-6 mb-8 flex-1 flex flex-col justify-center">
                <h3 class="text-2xl font-bold text-white text-center leading-snug">
                    {{ $quizData[$currentQuizIdx]['question'] }}
                </h3>
            </div>

            <div class="space-y-3 mt-auto">
                @foreach($quizData[$currentQuizIdx]['options'] as $option)
                <button wire:click="answerQuiz({{ $option['correct'] ? 'true' : 'false' }})" 
                    class="w-full glass-btn rounded-2xl p-4 text-left flex items-center gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-slate-800/50 border border-slate-700 flex items-center justify-center text-slate-400 font-bold group-hover:bg-blue-500/20 group-hover:border-blue-500/50 group-hover:text-blue-400 transition-colors">
                        {{ chr(65 + $loop->index) }}
                    </div>
                    <span class="text-white font-medium flex-1">{{ $option['text'] }}</span>
                </button>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ============================== --}}
        {{-- STEP: FLIGHT --}}
        {{-- ============================== --}}
        @if($step === 'flight')
        <div class="flex flex-col h-full animate-in fade-in slide-in-from-right-8 duration-500">
            <div class="glass-panel rounded-3xl p-4 mb-4 text-center shrink-0">
                <p class="text-xs text-slate-300 font-medium">Sentuh layar untuk mengendalikan pesawat.</p>
                <div class="flex justify-center gap-4 mt-2 text-xs">
                    <span class="flex items-center gap-1"><span class="text-green-400">💚</span> +10</span>
                    <span class="flex items-center gap-1"><span class="text-red-400">❤️</span> -5</span>
                </div>
            </div>

            <div class="flex-1 glass-panel rounded-3xl overflow-hidden relative border-blue-500/20 shadow-[0_0_30px_rgba(59,130,246,0.15)] min-h-[50vh]"
                x-init="
                const container = $el;
                const W = container.clientWidth, H = container.clientHeight;
                const scene = new THREE.Scene();
                scene.background = new THREE.Color(0x0f172a);
                const camera = new THREE.PerspectiveCamera(75, W/H, 0.1, 1000);
                const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
                renderer.setSize(W, H);
                container.appendChild(renderer.domElement);

                const dLight = new THREE.DirectionalLight(0xffffff, 1.5);
                dLight.position.set(5, 10, 5);
                scene.add(dLight);
                scene.add(new THREE.AmbientLight(0x404040, 2));

                const starGeo = new THREE.BufferGeometry();
                const starVerts = [];
                for(let i=0; i<200; i++) {
                    starVerts.push((Math.random()-0.5)*100, (Math.random()-0.5)*100, (Math.random()-0.5)*50-10);
                }
                starGeo.setAttribute('position', new THREE.Float32BufferAttribute(starVerts, 3));
                scene.add(new THREE.Points(starGeo, new THREE.PointsMaterial({color: 0x94a3b8, size: 0.1})));

                const planeGroup = new THREE.Group();
                const bGeo = new THREE.BoxGeometry(0.3, 0.2, 1.2);
                const bMat = new THREE.MeshPhongMaterial({color: 0x3b82f6});
                planeGroup.add(new THREE.Mesh(bGeo, bMat));
                const wGeo = new THREE.BoxGeometry(1.5, 0.05, 0.4);
                const wMat = new THREE.MeshPhongMaterial({color: 0x60a5fa});
                planeGroup.add(new THREE.Mesh(wGeo, wMat));
                scene.add(planeGroup);
                camera.position.z = 5;

                // UI Overlay in Canvas
                const hud = document.createElement('div');
                hud.className = 'absolute top-3 left-4 right-4 flex justify-between items-center pointer-events-none';
                hud.innerHTML = `
                    <div class='glass-panel px-3 py-1 rounded-full text-white font-bold text-sm border-white/10'>⏱️ <span id='timer'>30</span>s</div>
                    <div class='glass-panel px-3 py-1 rounded-full text-white font-bold text-sm border-white/10 text-yellow-400'>⭐ <span id='flightScore'>0</span></div>
                `;
                container.appendChild(hud);

                let mouseX = 0, mouseY = 0;
                const updatePos = (cx, cy) => {
                    const r = container.getBoundingClientRect();
                    mouseX = ((cx - r.left) / W) * 8 - 4;
                    mouseY = -((cy - r.top) / H) * 10 + 5;
                };
                container.addEventListener('mousemove', e => updatePos(e.clientX, e.clientY));
                container.addEventListener('touchmove', e => { e.preventDefault(); updatePos(e.touches[0].clientX, e.touches[0].clientY); }, {passive: false});

                const items = [];
                function spawn() {
                    const isGood = Math.random() > 0.3;
                    const geo = isGood ? new THREE.IcosahedronGeometry(0.3) : new THREE.OctahedronGeometry(0.3);
                    const mat = new THREE.MeshPhongMaterial({
                        color: isGood ? 0x22c55e : 0xef4444, 
                        emissive: isGood ? 0x22c55e : 0xef4444,
                        emissiveIntensity: 0.5
                    });
                    const m = new THREE.Mesh(geo, mat);
                    m.position.set((Math.random()*8)-4, (Math.random()*10)-5, -20);
                    m.userData = { isGood };
                    scene.add(m);
                    items.push(m);
                }

                let frames = 0, score = 0, active = true;
                const limit = 1800; // 30s @ 60fps

                function animate() {
                    if(!active) return;
                    requestAnimationFrame(animate);
                    frames++;
                    
                    document.getElementById('timer').innerText = Math.max(0, Math.ceil((limit - frames)/60));

                    planeGroup.position.x += (mouseX - planeGroup.position.x) * 0.1;
                    planeGroup.position.y += (mouseY - planeGroup.position.y) * 0.1;
                    planeGroup.rotation.z = -(mouseX - planeGroup.position.x) * 0.2;
                    planeGroup.rotation.x = (mouseY - planeGroup.position.y) * 0.1;

                    if(frames % 40 === 0) spawn();

                    for(let i=items.length-1; i>=0; i--) {
                        let it = items[i];
                        it.position.z += 0.25;
                        it.rotation.x += 0.05;
                        it.rotation.y += 0.05;

                        if(planeGroup.position.distanceTo(it.position) < 0.8) {
                            score = Math.max(0, score + (it.userData.isGood ? 10 : -5));
                            document.getElementById('flightScore').innerText = score;
                            scene.remove(it);
                            items.splice(i,1);
                        } else if(it.position.z > 6) {
                            scene.remove(it);
                            items.splice(i,1);
                        }
                    }
                    renderer.render(scene, camera);

                    if(frames >= limit) {
                        active = false;
                        $wire.finishFlight(score);
                    }
                }
                animate();
                ">
            </div>
        </div>
        @endif

        {{-- ============================== --}}
        {{-- STEP: WORD SEARCH --}}
        {{-- ============================== --}}
        @if($step === 'wordle')
        <div class="flex flex-col h-full animate-in fade-in slide-in-from-right-8 duration-500 pt-4" 
             x-data="wordSearchComponent(@js($wsGrid), @js($wsWords))">
            <div class="text-center mb-4 shrink-0">
                <h2 class="text-2xl font-bold text-white">Cari Kata</h2>
                <p class="text-sm text-slate-400">Temukan <span x-text="words.length - foundWords.length"></span> kata tersembunyi!</p>
            </div>
            
            <div class="flex justify-center flex-wrap gap-2 mb-4 px-4 shrink-0">
                <template x-for="word in words">
                    <span class="px-2 py-1 text-xs font-bold rounded-lg" 
                          :class="foundWords.includes(word) ? 'bg-green-500/20 border border-green-500/30 text-green-400 line-through' : 'bg-slate-800 border border-slate-700 text-slate-400'"
                          x-text="word"></span>
                </template>
            </div>

            <div class="flex-1 flex justify-center items-center p-2 mb-4 shrink-0">
                <div class="grid grid-cols-10 gap-1 touch-none"
                     @touchstart.prevent="handleStart($event)"
                     @touchmove.prevent="handleMove($event)"
                     @touchend.prevent="handleEnd()"
                     @mousedown.prevent="handleStart($event)"
                     @mousemove.prevent="handleMove($event)"
                     @mouseup.prevent="handleEnd()"
                     @mouseleave.prevent="handleEnd()"
                     id="ws-grid">
                    @foreach($wsGrid as $r => $row)
                        @foreach($row as $c => $letter)
                            <div class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg text-lg font-bold select-none cursor-pointer transition-colors duration-200"
                                 data-r="{{ $r }}" data-c="{{ $c }}"
                                 :class="{
                                    'bg-blue-500 text-white shadow-[0_0_15px_rgba(59,130,246,0.5)]': isSelecting && isSelected({{ $r }}, {{ $c }}),
                                    'bg-green-500 text-white shadow-[0_0_15px_rgba(34,197,94,0.5)]': !isSelecting && isFound({{ $r }}, {{ $c }}),
                                    'bg-slate-800 text-slate-300 border border-slate-700': (!isSelecting || !isSelected({{ $r }}, {{ $c }})) && !isFound({{ $r }}, {{ $c }})
                                 }">
                                {{ $letter }}
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- ============================== --}}
        {{-- STEP: MATCH --}}
        {{-- ============================== --}}
        @if($step === 'match')
        <div class="flex flex-col h-full animate-in fade-in slide-in-from-right-8 duration-500 pt-4" x-on:unflip-cards.window="setTimeout(() => { $wire.unflipCards() }, 800)">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white">Cocokkan Kartu</h2>
                <div class="flex justify-center gap-4 mt-1 text-sm font-medium">
                    <span class="text-slate-400">Pasangan: <span class="text-white">{{ $matchPairsFound }}/8</span></span>
                    <span class="text-slate-400">Langkah: <span class="text-white">{{ $matchAttempts }}</span></span>
                </div>
            </div>

            <div class="flex-1 flex flex-col items-center justify-center mb-4">
                <div class="grid grid-cols-4 gap-2 sm:gap-3 w-full max-w-[320px]">
                    @foreach($matchCards as $card)
                        <button wire:click="flipMatchCard({{ $card['id'] }})" 
                            @disabled($card['flipped'] || $card['matched'])
                            class="aspect-square relative rounded-2xl cursor-pointer transition-transform duration-500 transform-style-3d {{ ($card['flipped'] || $card['matched']) ? '[transform:rotateY(180deg)]' : 'active:scale-95' }}">
                            
                            {{-- Back of card (Hidden when flipped) --}}
                            <div class="absolute inset-0 backface-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 border border-white/20 shadow-lg flex items-center justify-center">
                                <span class="text-white/50 text-xl font-bold">?</span>
                            </div>
                            
                            {{-- Front of card (Visible when flipped) --}}
                            <div class="absolute inset-0 backface-hidden rounded-2xl bg-white flex items-center justify-center text-3xl sm:text-4xl shadow-inner border-2 border-slate-200 overflow-hidden [transform:rotateY(180deg)] {{ $card['matched'] ? 'opacity-50 scale-95 ring-4 ring-green-400' : '' }}">
                                @if($card['type'] === 'image')
                                    <img src="{{ Storage::url($card['content']) }}" class="w-full h-full object-cover p-1 rounded-xl" alt="card" />
                                @else
                                    {{ $card['content'] }}
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
            
            <button wire:click="prepareMatch" class="mt-auto glass-btn text-white w-full py-3 rounded-xl font-bold text-sm">
                Acak Ulang
            </button>
        </div>
        <style>
            .transform-style-3d { transform-style: preserve-3d; }
            .backface-hidden { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
        </style>
        @endif

        {{-- ============================== --}}
        {{-- STEP: RESULT --}}
        {{-- ============================== --}}
        @if($step === 'result')
        <div class="flex flex-col h-full items-center justify-center animate-in zoom-in-95 duration-500"
            x-init="setTimeout(() => { confetti({ particleCount: 150, spread: 80, origin: { y: 0.6 }, colors: ['#3b82f6', '#8b5cf6', '#ec4899'] }); }, 300)">
            
            <div class="glass-panel w-full rounded-3xl p-8 text-center shadow-2xl relative overflow-hidden">
                <div class="absolute inset-0 premium-gradient opacity-10"></div>
                
                <div class="relative z-10">
                    <div class="text-6xl mb-4 drop-shadow-[0_0_20px_rgba(250,204,21,0.6)]">🏆</div>
                    <h2 class="text-2xl font-extrabold text-white mb-1">Misi Selesai!</h2>
                    <p class="text-slate-400 text-sm mb-6">Kamu telah menyelesaikan misi <span class="text-white font-bold uppercase">{{ $selectedGame }}</span></p>

                    <div class="inline-block p-1 rounded-2xl premium-gradient mb-8">
                        <div class="bg-slate-900 rounded-xl px-8 py-4 text-center min-w-[160px]">
                            <span class="block text-xs font-bold text-slate-400 mb-1 uppercase tracking-wider">Total Skor</span>
                            <span class="text-5xl font-black premium-gradient-text">{{ $score }}</span>
                        </div>
                    </div>

                    <button wire:click="resetGame" class="w-full premium-gradient text-white rounded-2xl py-4 font-bold text-lg shadow-lg active:scale-95 transition-transform flex items-center justify-center gap-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" /></svg>
                        Main Misi Lainnya
                    </button>
                    
                    <button @click="showLeaderboard = true" class="w-full glass-btn text-white rounded-2xl py-3 font-bold text-sm shadow-lg active:scale-95 transition-transform flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        Lihat Papan Peringkat
                    </button>
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- ============================== --}}
    {{-- OVERLAY: LEADERBOARD --}}
    {{-- ============================== --}}
    <div x-show="showLeaderboard" style="display: none;" class="fixed inset-0 z-50 flex items-end justify-center" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-full">
        
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="showLeaderboard = false"></div>
        
        <div class="relative w-full max-w-md bg-slate-900 border-t border-slate-700 rounded-t-3xl shadow-2xl overflow-hidden max-h-[85vh] flex flex-col">
            <div class="p-4 border-b border-slate-800 flex justify-between items-center bg-slate-900/50 backdrop-blur shrink-0">
                <h3 class="font-bold text-white text-lg flex items-center gap-2">🏅 Papan Peringkat</h3>
                <button @click="showLeaderboard = false" class="w-8 h-8 rounded-full glass-btn flex items-center justify-center text-slate-400 hover:text-white">
                    ✕
                </button>
            </div>
            
            <div class="overflow-y-auto p-4 space-y-6 no-scrollbar pb-10">
                @foreach(['quiz' => '📚 Cerdas Cermat', 'flight' => '✈️ Terbang', 'wordle' => '🔎 Cari Kata', 'match' => '🃏 Kartu'] as $type => $label)
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 px-2">{{ $label }}</h4>
                    <div class="glass-panel rounded-2xl overflow-hidden divide-y divide-slate-700/50">
                        @forelse($leaderboards[$type] as $idx => $entry)
                            <div class="flex items-center justify-between p-3 {{ $entry->player_name === $playerName && $selectedGame === $type ? 'bg-blue-500/10' : '' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $idx === 0 ? 'bg-yellow-500/20 text-yellow-400' : ($idx === 1 ? 'bg-slate-400/20 text-slate-300' : ($idx === 2 ? 'bg-amber-600/20 text-amber-500' : 'text-slate-500')) }}">
                                        {{ $idx + 1 }}
                                    </div>
                                    <span class="text-sm font-medium text-white truncate max-w-[150px]">{{ $entry->player_name }}</span>
                                </div>
                                <span class="text-sm font-black premium-gradient-text">{{ $entry->score }}</span>
                            </div>
                        @empty
                            <div class="p-4 text-center text-sm text-slate-500 font-medium">Belum ada skor tercatat.</div>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ============================== --}}
    {{-- OVERLAY: HELP MODAL --}}
    {{-- ============================== --}}
    <div x-show="showHelp" style="display: none;" class="fixed inset-0 z-50 flex items-end justify-center" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-full">
        
        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" @click="showHelp = false"></div>
        
        <div class="relative w-full max-w-md bg-slate-900 border-t border-slate-700 rounded-t-3xl shadow-2xl p-6 pb-8 space-y-6">
            <div class="w-12 h-1.5 bg-slate-700 rounded-full mx-auto mb-2 opacity-50"></div>
            
            <h3 class="text-xl font-bold text-white mb-2">Panduan Misi</h3>
            
            <div class="space-y-4">
                <div class="flex gap-4 p-3 rounded-2xl bg-blue-500/10 border border-blue-500/20">
                    <div class="text-2xl mt-0.5 shrink-0">📚</div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-400">Cerdas Cermat</h4>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">Jawab pertanyaan kuis dengan benar. Setiap jawaban tepat memberi +20 Skor.</p>
                    </div>
                </div>
                
                <div class="flex gap-4 p-3 rounded-2xl bg-purple-500/10 border border-purple-500/20">
                    <div class="text-2xl mt-0.5 shrink-0">✈️</div>
                    <div>
                        <h4 class="text-sm font-bold text-purple-400">Sekolah Rimba</h4>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">Sentuh dan geser jari di layar. Ambil 💚 (+10) dan hindari ❤️ (-5). Waktu 30 detik!</p>
                    </div>
                </div>

                <div class="flex gap-4 p-3 rounded-2xl bg-green-500/10 border border-green-500/20">
                    <div class="text-2xl mt-0.5 shrink-0">🔎</div>
                    <div>
                        <h4 class="text-sm font-bold text-green-400">Cari Kata</h4>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">Geser jarimu secara vertikal atau horizontal untuk menemukan kata yang tersembunyi.</p>
                    </div>
                </div>

                <div class="flex gap-4 p-3 rounded-2xl bg-orange-500/10 border border-orange-500/20">
                    <div class="text-2xl mt-0.5 shrink-0">🃏</div>
                    <div>
                        <h4 class="text-sm font-bold text-orange-400">Cocokkan Kartu</h4>
                        <p class="text-xs text-slate-300 mt-1 leading-relaxed">Pilih 2 kartu untuk dicocokkan. Semakin sedikit langkah yang digunakan, semakin besar skornya!</p>
                    </div>
                </div>
            </div>
            
            <button @click="showHelp = false" class="w-full glass-btn text-white rounded-2xl py-3.5 font-bold mt-4 shadow-sm active:scale-95 transition-transform">
                Mengerti
            </button>
        </div>
    </div>

    <script>
        function wordSearchComponent(grid, words) {
            return {
                grid: grid,
                words: words,
                foundWords: [],
                foundCells: [],
                selectedCells: [],
                isSelecting: false,
                startCell: null,
                
                getCellFromEvent(e) {
                    let clientX, clientY;
                    if(e.touches && e.touches.length > 0) {
                        clientX = e.touches[0].clientX;
                        clientY = e.touches[0].clientY;
                    } else {
                        clientX = e.clientX;
                        clientY = e.clientY;
                    }
                    let el = document.elementFromPoint(clientX, clientY);
                    if(el && el.hasAttribute('data-r')) {
                        return { r: parseInt(el.getAttribute('data-r')), c: parseInt(el.getAttribute('data-c')) };
                    }
                    return null;
                },

                handleStart(e) {
                    let cell = this.getCellFromEvent(e);
                    if(cell) {
                        this.isSelecting = true;
                        this.startCell = cell;
                        this.selectedCells = [cell];
                    }
                },

                handleMove(e) {
                    if(!this.isSelecting || !this.startCell) return;
                    let cell = this.getCellFromEvent(e);
                    if(cell) {
                        this.selectedCells = [];
                        let sr = this.startCell.r, sc = this.startCell.c;
                        let er = cell.r, ec = cell.c;
                        
                        // Only horizontal or vertical
                        if(sr === er) {
                            let min = Math.min(sc, ec), max = Math.max(sc, ec);
                            for(let i=min; i<=max; i++) this.selectedCells.push({r: sr, c: i});
                        } else if(sc === ec) {
                            let min = Math.min(sr, er), max = Math.max(sr, er);
                            for(let i=min; i<=max; i++) this.selectedCells.push({r: i, c: sc});
                        }
                    }
                },

                handleEnd() {
                    if(!this.isSelecting) return;
                    this.isSelecting = false;
                    
                    if(this.selectedCells.length > 0) {
                        let word1 = this.selectedCells.map(c => this.grid[c.r][c.c]).join('');
                        let word2 = this.selectedCells.map(c => this.grid[c.r][c.c]).reverse().join('');
                        
                        let found = this.words.find(w => !this.foundWords.includes(w) && (w === word1 || w === word2));
                        if(found) {
                            this.foundWords.push(found);
                            this.foundCells.push(...this.selectedCells);
                            
                            if(this.foundWords.length === this.words.length) {
                                this.$wire.finishWordSearch();
                            }
                        }
                    }
                    this.selectedCells = [];
                    this.startCell = null;
                },

                isSelected(r, c) {
                    return this.selectedCells.some(cell => cell.r === r && cell.c === c);
                },

                isFound(r, c) {
                    return this.foundCells.some(cell => cell.r === r && cell.c === c);
                }
            }
        }
    </script>
</div>