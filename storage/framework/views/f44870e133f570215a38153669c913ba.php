<?php $__env->startSection('title', 'Asisten AI TernakPark'); ?>
<?php $__env->startSection('header-title', 'Asisten AI TernakPark'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col h-[calc(100vh-200px)] glass-card overflow-hidden rounded-2xl">
    
    <div class="bg-gradient-to-r from-emerald-800/90 to-emerald-900/90 backdrop-blur-sm px-6 py-4 flex items-center space-x-3 border-b border-white/20">
        <div class="w-10 h-10 rounded-full bg-emerald-500/30 flex items-center justify-center">
            <i class="fas fa-robot text-emerald-300 text-xl"></i>
        </div>
        <div>
            <h2 class="text-white font-semibold text-lg">Asisten AI TernakPark</h2>
            <p class="text-emerald-200/70 text-xs flex items-center gap-1">
                <span class="w-2 h-2 bg-green-400 rounded-full inline-block"></span> Online • Siap membantu
            </p>
        </div>
    </div>

    
    <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-black/20">
        
        <div class="flex items-start space-x-3">
            <div class="w-8 h-8 rounded-full bg-emerald-500/30 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-robot text-emerald-300 text-sm"></i>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl rounded-tl-none px-4 py-3 shadow-md max-w-3xl border border-white/10">
                <p class="text-gray-200 text-sm">Halo! Saya asisten AI TernakPark. Saya bisa membantu:</p>
                <ul class="list-disc list-inside text-sm text-gray-300 mt-2 space-y-1">
                    <li>Prediksi pertumbuhan bobot domba (contoh: "prediksi T001")</li>
                    <li>Formulasi pakan berdasarkan berat dan target PBBH</li>
                    <li>Perencanaan pakan berdasarkan jenis kandang</li>
                    <li>Informasi total ternak, kandang, dan stok pakan</li>
                    <li>Data ternak di kandang tertentu</li>
                    <li>Riwayat prediksi terbaru dan saran pakan praktis</li>
                </ul>
                <p class="text-xs text-emerald-300/70 mt-3">✨ Ketik "kemudahan" untuk panduan lengkap!</p>
            </div>
        </div>
    </div>

    
    <div class="border-t border-white/10 p-4 bg-black/30 backdrop-blur-sm">
        <div class="flex justify-between items-center mb-2 px-1">
            <button id="clear-chat" class="text-xs text-gray-400 hover:text-emerald-300 transition underline">
                Hapus Riwayat Chat
            </button>
            <p class="text-xs text-gray-400">Press Enter to send</p>
        </div>
        <form id="chat-form" class="flex space-x-3">
            <?php echo csrf_field(); ?>
            <input type="text" id="chat-input"
                   placeholder="Ketik pesan Anda di sini..."
                   class="flex-1 rounded-xl bg-white/10 border border-white/20 px-4 py-2.5 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition">
            <button type="submit"
                    class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-5 py-2 rounded-xl transition flex items-center gap-2 shadow-md">
                <i class="fas fa-paper-plane"></i>
                <span>Kirim</span>
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const clearChatBtn = document.getElementById('clear-chat');

    // ==================== CHAT HISTORY FUNCTIONS ====================
    function saveChatHistory() {
        const messages = [];
        const messageElements = chatMessages.querySelectorAll('.flex.items-start');
        messageElements.forEach(el => {
            const isUser = el.classList.contains('flex-row-reverse');
            const textElement = el.querySelector('.rounded-2xl p-3');
            if (textElement) {
                const text = textElement.querySelector('p')?.innerText || '';
                messages.push({ sender: isUser ? 'user' : 'bot', text: text });
            }
        });
        localStorage.setItem('ternakpark_chat_history', JSON.stringify(messages));
    }

    function loadChatHistory() {
        const history = localStorage.getItem('ternakpark_chat_history');
        if (history) {
            const messages = JSON.parse(history);
            messages.forEach(msg => {
                addMessage(msg.sender === 'user' ? 'Anda' : 'Asisten', msg.text, msg.sender === 'user');
            });
        }
    }

    function clearChatHistory() {
        localStorage.removeItem('ternakpark_chat_history');
        chatMessages.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 rounded-full bg-emerald-500/30 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-emerald-300 text-sm"></i>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl rounded-tl-none px-4 py-3 shadow-md max-w-3xl border border-white/10">
                    <p class="text-gray-200 text-sm">Halo! Saya asisten AI TernakPark dengan integrasi Machine Learning. Saya bisa membantu:</p>
                    <ul class="list-disc list-inside text-sm text-gray-300 mt-2 space-y-1">
                        <li>Prediksi pertumbuhan bobot domba (contoh: "prediksi T001")</li>
                        <li>Formulasi pakan berdasarkan berat dan target PBBH</li>
                        <li>Perencanaan pakan berdasarkan jenis kandang</li>
                        <li>Informasi total ternak, kandang, dan stok pakan</li>
                        <li>Data ternak di kandang tertentu</li>
                        <li>Riwayat prediksi terbaru dan saran pakan praktis</li>
                    </ul>
                    <p class="text-xs text-emerald-300/70 mt-3">✨ Ketik "kemudahan" untuk panduan lengkap! Sistem menggunakan ML untuk prediksi akurat 🧠</p>
                </div>
            </div>
        `;
    }

    function addMessage(sender, text, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex items-start space-x-3 ${isUser ? 'flex-row-reverse space-x-reverse' : ''}`;

        const avatar = document.createElement('div');
        avatar.className = `w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${isUser ? 'bg-emerald-600/50' : 'bg-emerald-500/30'}`;
        avatar.innerHTML = isUser ? '<i class="fas fa-user text-emerald-200 text-sm"></i>' : '<i class="fas fa-robot text-emerald-300 text-sm"></i>';

        const bubble = document.createElement('div');
        bubble.className = `rounded-2xl px-4 py-3 shadow-md max-w-3xl ${isUser ? 'bg-emerald-600/30 rounded-tr-none border border-emerald-500/30' : 'bg-white/10 rounded-tl-none border border-white/10'}`;
        bubble.innerHTML = `<p class="text-gray-200 text-sm whitespace-pre-line">${escapeHtml(text)}</p>`;

        messageDiv.appendChild(avatar);
        messageDiv.appendChild(bubble);
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        saveChatHistory();
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        }).replace(/\n/g, '<br>');
    }

    function showTyping() {
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'flex items-start space-x-3';
        typingDiv.innerHTML = `
            <div class="w-8 h-8 rounded-full bg-emerald-500/30 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-robot text-emerald-300 text-sm"></i>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl rounded-tl-none px-4 py-3 shadow-md border border-white/10">
                <div class="flex space-x-1.5">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.15s"></div>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                </div>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function hideTyping() {
        const typing = document.getElementById('typing-indicator');
        if (typing) typing.remove();
    }

    async function sendMessage(message) {
        if (!message.trim()) return;
        addMessage('Anda', message, true);
        chatInput.value = '';
        showTyping();

        try {
            const response = await fetch('/api/chatbot-public', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            const data = await response.json();
            hideTyping();
            if (data.reply) {
                addMessage('Asisten', data.reply);
            } else {
                addMessage('Asisten', 'Maaf, asisten tidak memberikan jawaban.');
            }
        } catch (error) {
            hideTyping();
            console.error('Chat error:', error);
            addMessage('Asisten', `❌ Gagal terhubung ke server: ${error.message}. Pastikan backend berjalan di port 8000.`);
        }
    }

    chatForm.addEventListener('submit', (e) => {
        e.preventDefault();
        sendMessage(chatInput.value);
    });

    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage(chatInput.value);
        }
    });

    clearChatBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (confirm('Apakah Anda yakin ingin menghapus semua riwayat chat?')) {
            clearChatHistory();
        }
    });

    document.addEventListener('DOMContentLoaded', loadChatHistory);
    chatInput.focus();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas Akhir\2. Eksperimen Utama Tahap Machine Learning Aplikasi Keseluruhan\Aplikasi_TernakParkWonosalam REST API\ternakpark-frontend\resources\views/predictions/index.blade.php ENDPATH**/ ?>