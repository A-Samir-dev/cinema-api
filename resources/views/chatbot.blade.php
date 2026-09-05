<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AI Chatbot Assistant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="chat-box mb-4 p-4 border rounded" id="chatBox" style="height: 400px; overflow-y: auto; background-color: #f9fafb;">
                    <div class="text-gray-500 text-center my-3">مرحباً بك! يمكنك طرح أي سؤال على الذكاء الاصطناعي.</div>
                </div>

                <form id="chatForm" class="flex gap-2">
                    @csrf
                    <input type="text" id="userInput" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="اكتب رسالتك هنا..." required autocomplete="off">
                    <button type="submit" id="sendBtn" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        إرسال
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
    document.getElementById('chatForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const input = document.getElementById('userInput');
        const chatBox = document.getElementById('chatBox');
        const sendBtn = document.getElementById('sendBtn');
        const message = input.value.trim();
        
        if(!message) return;

        // عرض رسالة المستخدم
        chatBox.innerHTML += `<div class="flex justify-end mb-3"><div class="bg-indigo-600 text-white p-3 rounded-lg max-w-lg">${message}</div></div>`;
        input.value = '';
        sendBtn.disabled = true;
        chatBox.scrollTop = chatBox.scrollHeight;

        // مؤشر التحميل
        const loadingId = 'loading-' + Date.now();
        chatBox.innerHTML += `<div class="flex justify-start mb-3" id="${loadingId}"><div class="bg-gray-200 text-gray-600 p-3 rounded-lg">جاري التفكير...</div></div>`;
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            const response = await fetch("{{ route('chatbot.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            document.getElementById(loadingId).remove();

            if(data.status === 'success') {
                chatBox.innerHTML += `<div class="flex justify-start mb-3"><div class="bg-white border border-gray-200 text-gray-800 p-3 rounded-lg max-w-xl shadow-sm">${data.reply.replace(/\n/g, '<br>')}</div></div>`;
            } else {
                chatBox.innerHTML += `<div class="flex justify-start mb-3"><div class="bg-red-500 text-white p-3 rounded-lg">حدث خطأ، حاول مرة أخرى.</div></div>`;
            }
        } catch (err) {
            document.getElementById(loadingId).remove();
            chatBox.innerHTML += `<div class="flex justify-start mb-3"><div class="bg-red-500 text-white p-3 rounded-lg">تعذر الاتصال بالسيرفر.</div></div>`;
        }

        sendBtn.disabled = false;
        chatBox.scrollTop = chatBox.scrollHeight;
    });
    </script>
</x-app-layout>