<?php

namespace App\Livewire;

use App\Models\FrontendText;
use App\Models\GameScore;
use Livewire\Component;

class RaheelaFairGame extends Component
{
    public $step = 'menu'; // menu, select_game, quiz, flight, result

    public $playerName = '';

    public $selectedGame = ''; // quiz, flight, pet

    public $score = 0;

    public $quizData = [];

    public $currentQuizIdx = 0;

    public $leaderboards = [
        'quiz' => [],
        'flight' => [],
        'wordle' => [],
        'match' => [],
    ];

    // Word Search State
    public $wsGrid = [];
    public $wsWords = [];

    // Match State
    public $matchCards = [];
    public $matchFlippedIds = [];
    public $matchPairsFound = 0;
    public $matchAttempts = 0;

    public function mount()
    {
        $this->loadLeaderboards();
    }

    public function loadLeaderboards()
    {
        $this->leaderboards['quiz'] = GameScore::where('game_type', 'quiz')->orderBy('score', 'desc')->take(5)->get();
        $this->leaderboards['flight'] = GameScore::where('game_type', 'flight')->orderBy('score', 'desc')->take(5)->get();
        $this->leaderboards['wordle'] = GameScore::where('game_type', 'wordle')->orderBy('score', 'desc')->take(5)->get();
        $this->leaderboards['match'] = GameScore::where('game_type', 'match')->orderBy('score', 'desc')->take(5)->get();
    }

    public function goToSelectGame()
    {
        $this->validate([
            'playerName' => 'required|min:2',
        ]);
        $this->step = 'select_game';
    }

    public function selectGame($game)
    {
        $this->selectedGame = $game;
        $this->score = 0;

        if ($game === 'quiz') {
            $this->prepareQuiz();
            $this->step = 'quiz';
        } elseif ($game === 'flight') {
            $this->step = 'flight';
        } elseif ($game === 'wordle') {
            $this->prepareWordSearch();
            $this->step = 'wordle';
        } elseif ($game === 'match') {
            $this->prepareMatch();
            $this->step = 'match';
        }
    }

    public function prepareQuiz()
    {
        $ft = FrontendText::first();
        $markdown = $ft?->game['quiz_markdown'] ?? <<<'MD'
---
title: Pemimpin Masa Depan
---
# Apa pilar pertama Sekolah Raheela?
- [x] Cinta Tanah Air
- [ ] Tidur Siang
- [ ] Makan Coklat
MD;

        $questions = [];
        $parts = preg_split('/#\s+/', $markdown);
        array_shift($parts); // Remove YAML

        foreach ($parts as $part) {
            $lines = explode("\n", trim($part));
            $qText = array_shift($lines);
            $options = [];
            foreach ($lines as $line) {
                if (preg_match('/-\s*\[(x|\s)\]\s*(.*)/', $line, $optMatch)) {
                    $options[] = [
                        'text' => trim($optMatch[2]),
                        'correct' => $optMatch[1] === 'x',
                    ];
                }
            }
            $questions[] = [
                'question' => $qText,
                'options' => $options,
            ];
        }

        $this->quizData = $questions;
        $this->currentQuizIdx = 0;
    }

    public function answerQuiz($isCorrect)
    {
        if ($isCorrect) {
            $this->score += 20;
        }

        if ($this->currentQuizIdx < count($this->quizData) - 1) {
            $this->currentQuizIdx++;
        } else {
            $this->saveScore();
        }
    }

    public function finishFlight($flightScore)
    {
        $this->score = $flightScore;
        $this->saveScore();
    }

    public function prepareWordSearch()
    {
        $ft = FrontendText::first();
        $wordsStr = $ft?->game['wordsearch_words'] ?? ['ISLAM','IMAN','IHSAN','PUASA','ZAKAT','SHOLAT'];
        
        $words = is_array($wordsStr) ? $wordsStr : array_filter(array_map('trim', explode(',', strtoupper($wordsStr))));
        $words = array_slice($words, 0, 10);
        usort($words, fn($a, $b) => strlen($b) - strlen($a));
        $this->wsWords = $words;

        $size = 10;
        $grid = array_fill(0, $size, array_fill(0, $size, ''));

        foreach ($words as $word) {
            $word = strtoupper($word);
            $len = strlen($word);
            $placed = false;
            $attempts = 0;
            while (!$placed && $attempts < 100) {
                $attempts++;
                $dir = rand(0, 1);
                $row = rand(0, $size - 1);
                $col = rand(0, $size - 1);

                if ($dir == 0 && $col + $len <= $size) {
                    $canPlace = true;
                    for ($i = 0; $i < $len; $i++) {
                        if ($grid[$row][$col + $i] !== '' && $grid[$row][$col + $i] !== $word[$i]) {
                            $canPlace = false;
                            break;
                        }
                    }
                    if ($canPlace) {
                        for ($i = 0; $i < $len; $i++) {
                            $grid[$row][$col + $i] = $word[$i];
                        }
                        $placed = true;
                    }
                } elseif ($dir == 1 && $row + $len <= $size) {
                    $canPlace = true;
                    for ($i = 0; $i < $len; $i++) {
                        if ($grid[$row + $i][$col] !== '' && $grid[$row + $i][$col] !== $word[$i]) {
                            $canPlace = false;
                            break;
                        }
                    }
                    if ($canPlace) {
                        for ($i = 0; $i < $len; $i++) {
                            $grid[$row + $i][$col] = $word[$i];
                        }
                        $placed = true;
                    }
                }
            }
        }

        // Fill empty cells
        for ($r = 0; $r < $size; $r++) {
            for ($c = 0; $c < $size; $c++) {
                if ($grid[$r][$c] === '') {
                    $grid[$r][$c] = chr(rand(65, 90));
                }
            }
        }
        
        $this->wsGrid = $grid;
        $this->score = 0;
    }

    public function finishWordSearch()
    {
        $this->score = 100;
        $this->saveScore();
    }

    public function prepareMatch()
    {
        $ft = FrontendText::first();
        $images = $ft?->game['match_images'] ?? [];
        
        if (empty($images) || count($images) < 8) {
            $items = ['🍎', '🚌', '📚', '🕌', '🏆', '🎨', '⚽', '🚀'];
            $type = 'emoji';
        } else {
            $items = array_slice($images, 0, 8);
            $type = 'image';
        }

        $deck = array_merge($items, $items);
        shuffle($deck);

        $this->matchCards = [];
        foreach ($deck as $idx => $item) {
            $this->matchCards[] = [
                'id' => $idx,
                'content' => $item,
                'type' => $type,
                'flipped' => false,
                'matched' => false,
            ];
        }
        $this->matchFlippedIds = [];
        $this->matchPairsFound = 0;
        $this->matchAttempts = 0;
        $this->score = 0;
    }

    public function flipMatchCard($id)
    {
        // Prevent flipping if already 2 cards flipped or card already matched/flipped
        if (count($this->matchFlippedIds) >= 2 || $this->matchCards[$id]['flipped'] || $this->matchCards[$id]['matched']) {
            return;
        }

        $this->matchCards[$id]['flipped'] = true;
        $this->matchFlippedIds[] = $id;

        if (count($this->matchFlippedIds) === 2) {
            $this->matchAttempts++;
            $id1 = $this->matchFlippedIds[0];
            $id2 = $this->matchFlippedIds[1];

            if ($this->matchCards[$id1]['content'] === $this->matchCards[$id2]['content']) {
                // Match found
                $this->matchCards[$id1]['matched'] = true;
                $this->matchCards[$id2]['matched'] = true;
                $this->matchPairsFound++;
                $this->matchFlippedIds = [];

                if ($this->matchPairsFound === 8) {
                    // Win: Base 100 points minus 2 points per attempt over 8
                    $this->score = max(20, 100 - (($this->matchAttempts - 8) * 5));
                    $this->saveScore();
                }
            } else {
                // No match, handled by JS timeout or next click? 
                // Let's use a Livewire event or a frontend timeout.
                // Actually, Livewire can dispatch a browser event to unflip after 1 second.
                $this->dispatch('unflip-cards');
            }
        }
    }

    public function unflipCards()
    {
        foreach ($this->matchFlippedIds as $id) {
            $this->matchCards[$id]['flipped'] = false;
        }
        $this->matchFlippedIds = [];
    }

    public function saveScore()
    {
        if ($this->playerName && $this->selectedGame) {
            GameScore::create([
                'player_name' => $this->playerName,
                'score' => $this->score,
                'game_type' => $this->selectedGame,
                'school_year' => '2025/2026',
            ]);
        }
        $this->loadLeaderboards();
        $this->step = 'result';
    }

    public function resetGame()
    {
        $this->step = 'select_game';
        $this->score = 0;
        $this->selectedGame = '';
    }

    public function backToMenu()
    {
        $this->step = 'menu';
        $this->playerName = '';
    }

    public function render()
    {
        return view('livewire.raheela-fair-game')->layout('layouts.game');
    }
}
