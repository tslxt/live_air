<template>
    <div>
        <div id="chat-history" v-bind:style="{height: this.chatViewHeight + 'px'}">
            <ul class="pb-3">
                <li class="col-sm" v-for="message in messages" v-bind:key="message.name">
                    <div v-if="message.from === currentUser.name">
                        <span class="font-weight-bold" v-bind:style="{color: msgColorSelf}">我说:</span>
                        <span v-bind:style="{color: msgColorSelf}" class="font-italic">{{ message.msg }}</span>
                    </div>
                    <div v-else>
                        <span class="font-weight-bold" v-bind:style="{color: msgColorOther}">{{ message.from}}</span>
                        <span v-bind:style="{color: msgColorOther}">说:</span>
                        <span v-bind:style="{color: msgColorOther}">{{ message.msg }}</span>
                    </div>
                    
                </li>
            </ul>
        </div>
        <div id="input-bar" class="fixed-bottom input-group">
            <input id="input-box" type="text" v-model="newMessage"  v-on:keyup.enter="sendMessage" class="col-sm form-control">
            <div class="input-group-append">
                <span class="input-group-text" v-on:click="sendMessage">发送</span>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        name: 'chat-box',
        props: [],
        data () {
            return {
                server: "123.57.45.169",
                // server: "127.0.0.1",
                port: 3014,
                gateRoute : 'gate.gateHandler.queryEntry',
                connectorRoute : 'connector.entryHandler.enter' ,
                chatRoute : 'chat.chatHandler.send',
                channel_id:null,
                newMessage: '',
                messages: [

                ],
                chatViewHeight: 100,
                pomelo: new Pomelo(),
                msgColorSelf: '#20c997',
                msgColorOther: '#ccc',
            }
        },
        computed: {
            currentUser() {
				return this.$store.getters.currentUser;
			},
        },
        mounted: function() {
            let height = window.innerHeight - $('video').height() - $('nav').height() - $('#input-bar').height();
            console.log('height: ', height);
            this.chatViewHeight = height;

            console.log(this.$route.params);
            let course_id = this.$route.params.course_id;
            this.channel_id = course_id;

            this.$el.querySelector('#input-box').addEventListener('blur', function () {
                setTimeout(function () {
                    window.scrollTo(0, 0)
                }, 100)
            });

            this.connectServer();
        },
        methods: {
            sendMessage () {
                if (this.newMessage) {
                    console.log('send message: ', this.newMessage);
                    // this.messages.push(this.newMessage);
                    // this.scrollToEnd();
                    this.sendOneMessage(this.newMessage);
                    window.scrollTo(0, 0);
                    this.newMessage = null;
                }
                
            },
            scrollToEnd: function() {    	
                var container = this.$el.querySelector("#chat-history");
                container.scrollTop = container.scrollHeight;
            },
            connectServer () {
                console.log('connectServer');
                this.pomelo.init({
                    host: this.server,
                    port: this.port,
                    log: true,
                    scheme: 'ws',
            
                    }, () => {
                    console.log('success');
                    this.pomelo.request(this.gateRoute, {
                        uid: this.currentUser.name,
                    }, (data) => {
                        console.log(data);
                        this.pomelo.disconnect();
                        if(data.code === 500) {
                            console.error('gate 连接失败');
                            return;
                        }
                        let host = data.host;
                        let port = data.port;
                        console.log(host, port);
                        this.enterChatRoom(host,port);
                    });
                });
            },
            enterChatRoom (host,port) {
                console.log('enterChatRoom');
                this.pomelo.init({
                    host: host,
                    port: port,
                    log: true,
                    scheme: 'ws',
            
                    reconnect: true,
                    maxReconnectAttempts: 5, // 最大重连尝试次数
                    reconnectionDelay: 2000 // 重连的 delay 时间
                    }, () => {
                        console.log('success');
                        this.pomelo.request(this.connectorRoute, {
                        username: this.currentUser.name,
                        rid: this.channel_id,
                    }, (data) => {
                        console.log(data);
                        let users = data.users;
                       
                        if(data.code === 500) {
                            console.error('gate 连接失败');
                            return;
                        }

                        this.registerEvent();
                    });
                });
            },
            registerEvent() {
                self = this
                console.log('register receive events');
                this.pomelo.on('onChat', function(data){
                    console.log('onChat',data);
                    self.messages.push(data);
                    self.scrollToEnd();
                });

                //update user list

                this.pomelo.on('onAdd', function(data) {
                    console.log(data);
                    
                });

                //update user list
                this.pomelo.on('onLeave', function(data) {
                    console.log(data);
                });
            },
            sendOneMessage (message) {
              console.log('sendOneMessage', message);
                var msg = message;
                var target = '*';
                this.pomelo.request(this.chatRoute, {
                    rid: this.channel_id,
                    content: msg,
                    from: this.currentUser.name,
                    target: target
                }, function(data) {
                    console.log(data);
                });

            },
        },
    }
</script>

<style scoped>
    input {
        border: 0px;
	 	border-radius: 2px;
    }
    span {
        border-radius: 0px;
        color: #009688;
    }
    #chat-history {
        overflow-y: auto;
    }
    ul {
        padding-left: 0px;
    }
    li {
        list-style: none;
        width: 100%;
        word-break: break-all;
        word-wrap: break-word;
    }
</style>



