@extends('admin.layouts.app')

@section('title', 'Chat | Admin')
@section('page', 'chat')
@section('breadcrumb')
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-item active">Chat</span>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-row">
            <div>
                <div class="page-pretitle">Apps</div>
                <h1 class="page-title">Chat</h1>
            </div>
            <!-- <div class="page-actions">
                <button class="btn btn-outline" onclick="refreshChat()">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7" cy="7" r="5"/><path d="M11 11l3.5 3.5"/></svg>
                    Refresh
                </button>
            </div> -->
        </div>
    </div>

    <div class="card" style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
        <div class="chat-layout" style="display: flex; height: 600px;">
            
            <!-- ── LEFT SIDEBAR (RAIL) ── -->
            <aside class="chat-rail" style="width: 380px; border-right: 1px solid #e9ecef; display: flex; flex-direction: column; background: #fff;">
                <div class="chat-rail-search" style="padding: 16px; border-bottom: 1px solid #e9ecef;">
                    <div style="position:relative;">
                        <svg style="position:absolute;left:12px;top:10px;width:16px;height:16px;color:#6c757d;" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7" cy="7" r="5"/><path d="M11 11l3.5 3.5"/></svg>
                        <input type="text" placeholder="Search conversations..." id="searchInput" onkeyup="searchConversations()" style="width:100%;padding:8px 8px 8px 36px;border:1px solid #e9ecef;border-radius:20px;font-size:14px;outline:none;">
                    </div>
                </div>
                
                <div class="chat-rail-tabs" style="display:flex;padding:8px 16px;border-bottom:1px solid #e9ecef;gap:8px;">
                    <button class="chart-tab active" onclick="filterChat('all')" style="border:none;background:transparent;font-weight:600;color:#6c757d;padding:4px 12px;border-radius:12px;cursor:pointer;">All</button>
                </div>
                
                <div class="chat-conversations" id="chat-conversations" style="flex:1;overflow-y:auto;padding:8px 0;">
                    <!-- Contacts Rendered by JavaScript -->
                </div>
            </aside>

            <!-- ── RIGHT THREAD ── -->
            <section class="chat-thread" style="flex:1;display:flex;flex-direction:column;background: #f8f9fa;">
                <header class="chat-thread-head" style="padding:16px 24px;background:#fff;border-bottom:1px solid #e9ecef;display:flex;justify-content:space-between;align-items:center;">
                    <div class="chat-thread-peer" style="display:flex;align-items:center;gap:12px;">
                        <div class="av" id="thread-avatar" style="width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;background:#20c997;">?</div>
                        <div>
                            <div class="name" id="thread-name" style="font-weight:600;font-size:16px;">Select a conversation</div>
                            <div class="presence" id="thread-presence" style="font-size:13px;color:#6c757d;">Click a contact to start</div>
                        </div>
                    </div>
                </header>

                <div class="chat-messages" id="chat-messages" style="flex:1;overflow-y:auto;padding:24px;display:flex;flex-direction:column;gap:8px;">
                    <div class="text-center text-muted p-5">Select a contact to view messages</div>
                </div>

                <form class="chat-composer" id="chat-composer" style="padding:16px 24px;background:#fff;border-top:1px solid #e9ecef;display:flex;gap:12px;align-items:center;">
                    <input type="text" id="chat-input" placeholder="Type your reply..." style="flex:1;padding:10px 16px;border:1px solid #e9ecef;border-radius:24px;font-size:14px;outline:none;" autocomplete="off" required>
                    <button type="submit" class="btn btn-primary composer-send" style="background:#20c997;border:none;border-radius:24px;padding:8px 24px;color:white;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2L7 9M14 2l-5 13-2-6-6-2 13-5z"/></svg>
                        Send
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- CSS for the Success/Error Toast Notifications --}}
    <style>
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
    </style>

    <script>
        let activeId = null;
        let contacts = [];
        let allContacts = [];
        
        // Color palette for avatars
        const colors = ['#20c997', '#0d6efd', '#6f42c1', '#fd7e14', '#dc3545', '#ffc107', '#17a2b8'];

        // ✅ 1. LOAD DATA DIRECTLY FROM LARAVEL
        document.addEventListener('DOMContentLoaded', function() {
            const dbData = @json($contacts);
            console.log("✅ Data passed directly from Laravel:", dbData.length, "contacts found.");
            
            allContacts = dbData;
            contacts = dbData;

            // ✅ Add a temporary array to each contact to store local unsaved messages
            contacts.forEach(c => {
                c.localMessages = []; 
            });

            renderRail();
            
            if (contacts.length > 0 && !activeId) {
                activeId = parseInt(contacts[0].id);
                renderThread();
            }
        });

        // 2. Render the Left Sidebar
        function renderRail() {
            const list = document.getElementById('chat-conversations');
            if (!contacts.length) {
                list.innerHTML = '<div class="text-center p-4 text-muted">No contacts yet</div>';
                return;
            }
            
            list.innerHTML = contacts.map((c, index) => {
                const name = c.name || c.email;
                const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                const color = colors[index % colors.length];
                const preview = c.message ? c.message.substring(0, 40) + (c.message.length > 40 ? '...' : '') : 'No message';
                
                return `
                    <button type="button" class="chat-conversation ${parseInt(c.id) === parseInt(activeId) ? 'active' : ''}" data-id="${c.id}" onclick="selectContact(${c.id})" style="display:flex;align-items:center;padding:12px 20px;width:100%;border:none;background:${parseInt(c.id) === parseInt(activeId) ? '#eefbf7' : 'transparent'};cursor:pointer;transition:0.2s;border-bottom:1px solid #f8f9fa;text-align:left;">
                        <span class="av" style="width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:600;background:${color};flex-shrink:0;margin-right:12px;">${initials}</span>
                        <span class="info" style="flex:1;">
                            <span class="row" style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                <span class="name" style="font-weight:600;font-size:14px;color:#212529;">${name}</span>
                            </span>
                            <span class="preview-row" style="display:block;">
                                <span class="preview" style="font-size:13px;color:#6c757d;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;">${preview}</span>
                            </span>
                        </span>
                    </button>
                `;
            }).join('');
        }

        function selectContact(id) {
            activeId = parseInt(id);
            renderRail();
            renderThread();
        }

        // 3. Render the Right Chat Thread
        function renderThread() {
            const conv = contacts.find((c) => parseInt(c.id) === parseInt(activeId));
            if (!conv) return;
            
            document.getElementById('thread-name').textContent = conv.name || conv.email;
            document.getElementById('thread-avatar').textContent = (conv.name || conv.email).split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            document.getElementById('thread-presence').innerHTML = `<span class="dot" style="display:inline-block;width:8px;height:8px;background:#28a745;border-radius:50%;margin-right:4px;"></span> Contact since ${new Date(conv.created_at).toLocaleDateString()}`;
            
            fetchMessages(conv.id);
        }

        // 4. Fetch the message from DB
        async function fetchMessages(contactId) {
            try {
                const response = await fetch(`/admin/chat/messages/${contactId}`);
                const data = await response.json();
                
                const messagesEl = document.getElementById('chat-messages');
                
                // Start with an empty array
                let allMessages = [];

                // Add DB messages (Initial contact message)
                if (data.messages && data.messages.length > 0) {
                    allMessages = data.messages;
                }

                // ✅ Add Local Messages (Not saved in DB, only in JS memory)
                const currentContact = contacts.find(c => parseInt(c.id) === parseInt(contactId));
                if (currentContact && currentContact.localMessages) {
                    currentContact.localMessages.forEach(msg => {
                        allMessages.push(msg);
                    });
                }

                // If there are absolutely no messages
                if (allMessages.length === 0) {
                    messagesEl.innerHTML = '<div class="text-center text-muted p-5">No messages yet</div>';
                    return;
                }
                
                messagesEl.innerHTML = allMessages.map((m) => {
                    const isMine = m.from === 'admin' || m.from === 'me';
                    return `
                        <div style="display:flex;flex-direction:column;align-items:${isMine ? 'flex-end' : 'flex-start'};margin-bottom:12px;">
                            <div style="max-width:70%;padding:10px 16px;border-radius:12px;background:${isMine ? '#20c997' : 'white'};color:${isMine ? 'white' : '#212529'};font-size:14px;line-height:1.5;${isMine ? 'border-bottom-right-radius:4px;' : 'border-bottom-left-radius:4px;'}box-shadow:0 1px 2px rgba(0,0,0,0.05);">
                                ${m.text}
                            </div>
                            <div style="font-size:11px;color:#adb5bd;margin-top:4px;${isMine ? 'text-align:right;' : 'text-align:left;'}">${m.time}</div>
                        </div>
                    `;
                }).join('');
                messagesEl.scrollTop = messagesEl.scrollHeight;
            } catch (error) {
                console.error('❌ Error fetching messages:', error);
            }
        }

        // ============================================
        // ✅ 5. SEND EMAIL TO USER (NO DATABASE SAVE)
        // ============================================
        document.getElementById('chat-composer').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const input = document.getElementById('chat-input');
            const text = input.value.trim();
            if (!text || !activeId) return;

            const sendBtn = document.querySelector('.composer-send');
            sendBtn.disabled = true;
            sendBtn.innerHTML = 'Sending...';

            try {
                const response = await fetch('/admin/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ contact_id: activeId, message: text })
                });

                // Check for server errors
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || `Server Error ${response.status}`);
                }

                const data = await response.json();
                
                if (data.success) {
                    // ✅ SAVE MESSAGE TO LOCAL MEMORY INSTEAD OF DB
                    const currentContact = contacts.find(c => parseInt(c.id) === parseInt(activeId));
                    if (currentContact) {
                        currentContact.localMessages.push({
                            text: text,
                            time: data.time,
                            from: 'admin'
                        });
                    }

                    // ✅ Append to UI
                    const messagesEl = document.getElementById('chat-messages');
                    messagesEl.innerHTML += `
                        <div style="display:flex;flex-direction:column;align-items:flex-end;margin-bottom:12px;">
                            <div style="max-width:70%;padding:10px 16px;border-radius:12px;background:#20c997;color:white;font-size:14px;border-bottom-right-radius:4px;box-shadow:0 1px 2px rgba(0,0,0,0.05);">${text}</div>
                            <div style="font-size:11px;color:#adb5bd;margin-top:4px;text-align:right;">${data.time}</div>
                        </div>
                    `;
                    messagesEl.scrollTop = messagesEl.scrollHeight;
                    input.value = '';
                    
                    // ✅ Show success popup
                    showNotification(`✅ Email sent to ${currentContact?.email || 'user'}`, 'success');
                } else {
                    showNotification('❌ Error: ' + (data.error || 'Unknown error'), 'error');
                }
            } catch (error) {
                console.error('❌ Send Error:', error);
                showNotification('❌ Mail Error: ' + error.message, 'error');
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = `<svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2L7 9M14 2l-5 13-2-6-6-2 13-5z"/></svg> Send`;
            }
        });

        // ============================================
        // ✅ 6. TOAST NOTIFICATION HELPER
        // ============================================
        function showNotification(message, type = 'success') {
            const existing = document.querySelector('.custom-toast-notification');
            if (existing) existing.remove();

            const notification = document.createElement('div');
            notification.className = 'custom-toast-notification';
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; padding: 12px 24px;
                background: ${type === 'success' ? '#28a745' : '#dc3545'};
                color: white; border-radius: 8px; z-index: 9999;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                animation: slideIn 0.4s ease; font-size: 14px;
                font-weight: 500; max-width: 350px;
                border-left: 4px solid ${type === 'success' ? '#1e7e34' : '#a71d2a'};
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Helper Functions
        function refreshChat() { window.location.reload(); }
        
        function searchConversations() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            contacts = allContacts.filter(c => (c.name || c.email).toLowerCase().includes(search));
            renderRail();
        }
        
        function filterChat(type) {
            contacts = type === 'all' ? allContacts : allContacts.filter(c => c.unread > 0);
            renderRail();
        }
    </script>
    
    <style>
        .chat-conversation:hover { background: #f8f9fa !important; }
        .chat-conversation.active { background: #eefbf7 !important; }
        .chat-conversation.active .name { color: #20c997 !important; }
        #chat-messages::-webkit-scrollbar { width: 6px; }
        #chat-messages::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }
        .chat-conversations::-webkit-scrollbar { width: 6px; }
        .chat-conversations::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }
    </style>
@endsection