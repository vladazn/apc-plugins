{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_navigation' append}
    <div class="help-info-container is--hidden" id="help-info-container">
        <div class="help-info-text">
            <span class="info-text-content">
                {s namespace='frontend/index/index' name='helpInfoText'}Wir helfen Ihnen gerne weiter!{/s}
            </span>
            <span class="close-btn-circle">
                <i class="icon--cross3"></i>
            </span>
        </div>
        <div class="help-info-properties">
            <div class="chat-property prop-container">
                <div class="chat-section section-style">
                    <span>Chat: <span class="prop-style infx--chat-status infx--chat-offline" id="infx--chat-status">Offline</span></span>
                </div>
                <div class="contact-link section-style" >
                    <span class="link-style infx--open-chat" id="infx--open-chat">{s namespace='frontend/index/index' name='contactProperty'}Sprechen Sie Uns an{/s}</span>
                </div>
            </div>
            <div class="number-property prop-container">
                <span class="phone-number section-style">
                    <i class="fa fa-phone"></i>
                    {s namespace='frontend/index/logo-container' name='infPhoneNumber'}1234 12345678{/s}
                </span>
                <span class="word-days-info section-style">{s namespace='frontend/index/index' name='workingDays'}Mo-So, 24/7{/s}</span>
            </div>
            <div class="questions-property prop-container">
                <span class="questions-text section-style">
                    <span class="ques-text">{s namespace='frontend/index/index' name='infxFaqTitle'}Fragen & Antworten{/s}</span>
                </span>
                <a href="{s namespace='frontend/index/index' name='infxFaqLink'}/faq{/s}" class="questions-link section-style">{s namespace='frontend/index/index' name='infxFaqText'}Hilfreiche Themen{/s}</a>
            </div>
        </div>
    </div>

    <div class="min-help-info">
        <div class="icons-section">
            <div class="all-sytle">
               <i class="icon--chat"></i>
            </div>
            <div class="all-sytle">
               <i class="icon--phone"></i>
            </div>
            <div class="all-sytle">
               <i class="icon--question"></i>
            </div>
        </div>
        <div class="text-section">
            <span>{s namespace='frontend/index/index' name='questionsMinText'}Noch Fragen{/s}</span>
        </div>
    </div>
{/block}

{block name='frontend_index_header_javascript' prepend}
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    Tawk_API.onLoad = function(){
        var pageStatus = Tawk_API.getStatus();
        if(pageStatus === 'online'){
             var chatStatus = document.getElementById("infx--chat-status");
            if(chatStatus){
            document.getElementById("infx--chat-status").classList.remove('infx--chat-offline');

            document.getElementById("infx--chat-status").classList.add('infx--chat-online');
            document.getElementById("infx--chat-status").innerHTML = 'Online';
    }
        }
    };

    var elementExists = document.getElementById("infx--open-chat");
    if(elementExists){
        document.getElementById('infx--open-chat').onclick = function(){
            document.getElementById('help-info-container').style.display = "none";
            Tawk_API.showWidget();
            Tawk_API.maximize();
        }
    }

    Tawk_API.onChatHidden = function(){
        document.getElementById('help-info-container').style.display = "block";
        Tawk_API.hideWidget();
    };
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/{config name="tawk_website_id"}/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
</script>
{/block}
