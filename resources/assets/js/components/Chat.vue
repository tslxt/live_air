<template>

   <div>
    <beautiful-chat
      :participants="participants"
      :titleImageUrl="titleImageUrl"
      :onMessageWasSent="onMessageWasSent"
      :messageList="messageList"
      :newMessagesCount="newMessagesCount"
      :isOpen="isChatOpen"
      :close="closeChat"
      :open="openChat"
      :colors="colors"
      :alwaysScrollToBottom="alwaysScrollToBottom"
      :messageStyling="messageStyling" />
  </div>

</template>

<script>
    export default {
    	name: 'Chat',
        props: [],
    	data () {
    		return {
    			server: "123.57.45.169",
                port: 3014,
    			channel_id:null,
                gateRoute : 'gate.gateHandler.queryEntry',
                connectorRoute : 'connector.entryHandler.enter' ,
                chatRoute : 'chat.chatHandler.send',
                pomelo: new Pomelo(),
                username: this.$root.user.name,
                participants: [
                {
                  id: 1,
                  name: "tester",
                  // imageUrl: 'https://avatars3.githubusercontent.com/u/1915989?s=230&v=4'
                },
                // {
                //   id: 'user2',
                //   name: 'Support',
                //   imageUrl: 'https://avatars3.githubusercontent.com/u/37018832?s=200&v=4'
                // }
              ], // the list of all the participant of the conversation. `name` is the user name, `id` is used to establish the author of a message, `imageUrl` is supposed to be the user avatar.
              titleImageUrl: 'https://a.slack-edge.com/66f9/img/avatars-teams/ava_0001-34.png',
              messageList: [
                  { type: 'text', author: `me`, data: { text: `Say yes!` } },
                  { type: 'text', author: `user1`, data: { text: `No.` } }
              ], // the list of the messages to show, can be paginated and adjusted dynamically
              newMessagesCount: 0,
              isChatOpen: false, // to determine whether the chat window should be open or closed
              showTypingIndicator: '', // when set to a value matching the participant.id it shows the typing indicator for the specific user
              colors: {
                header: {
                  bg: '#00796B',
                  text: '#ffffff'
                },
                launcher: {
                  bg: '#009688'
                },
                messageList: {
                  bg: '#B2DFDB'
                },
                sentMessage: {
                  bg: '#009688',
                  text: '#FFFFFF'
                },
                receivedMessage: {
                  bg: '#BDBDBD',
                  text: '#222222'
                },
                userInput: {
                  bg: '#009688',
                  text: '#FFFFFF'
                }
              }, 
              alwaysScrollToBottom: true ,
              messageStyling: false ,
    		}
    	},
        mounted() {
            console.log('Chat mounted');
            let course_id = this.$route.params.course_id;
            this.channel_id = course_id;
            // setTimeout(this.checkInfo(), 1000);
            setTimeout( () => {
              console.log('setTimeout');
              this.checkInfo();
            },1000);
        },
        computed: {
          
        },
        methods: {
          checkInfo () {
            if (this.$root.user.id) {
              this.username = this.$root.user.name || "未注册用户";
              this.connectServer();
            }else {
              setTimeout( () => {
                this.checkInfo();
              }, 1000 );
            }
          },
        	connectServer () {
                console.log('connectServer');
                this.pomelo.init({
                    host: this.server,
                    port: this.port,
                    log: true,
                    scheme: 'wws',
            
                    }, () => {
                    console.log('success');
                    this.pomelo.request(this.gateRoute, {
                        uid: this.username,
                    }, (data) => {
                        console.log(data);
                        this.pomelo.disconnect();
                        if(data.code === 500) {
                            console.error('gate 连接失败');
                            return;
                        }
                        this.server = data.host;
                        this.port = data.port;
                        console.log(this.server, this.port);
                        this.enterChatRoom();
                    });
                });
            },
            enterChatRoom () {
                console.log('enterChatRoom');
                this.pomelo.init({
                    host: this.server,
                    port: this.port,
                    log: true,
                    scheme: 'wws',
            
                    reconnect: true,
                    maxReconnectAttempts: 5, // 最大重连尝试次数
                    reconnectionDelay: 2000 // 重连的 delay 时间
                    }, () => {
                        console.log('success');
                        this.pomelo.request(this.connectorRoute, {
                        username: this.username,
                        rid: this.channel_id,
                    }, (data) => {
                        console.log(data);
                        let users = data.users;
                        
                        for (var i = 0; i < users.length; i++) {
                          let user = {id:users[i],name:users[i]}
                          this.participants.push(user);
                        }
                        if(data.code === 500) {
                            console.error('gate 连接失败');
                            return;
                        }
                        this.registerEvent();
                    });
                });
            },
            sendOneMessage (message) {
              console.log('sendOneMessage', message);
                var msg = message;
                var target = '*';
                this.pomelo.request(this.chatRoute, {
                    rid: this.channel_id,
                    content: msg,
                    from: this.username,
                    target: target
                }, function(data) {
                    console.log(data);
                });

            },
            registerEvent() {
                // const pomelo = window.Pomelo;
                self = this
                console.log('register receive events');
                console.log(this.pomelo);
                this.pomelo.on('onChat', function(data){
                  console.log('onChat',data);
                  // console.log(data.from, self.username, data.from === self.username);
                  if (data.from === self.username) {
                    return
                  }
                  self.newMessagesCount = self.isChatOpen ? self.newMessagesCount : self.newMessagesCount + 1;
                  self.onMessageWasSent({ author: data.from, type: 'text', data: { text : data.msg } });
                });


                //update user list

                this.pomelo.on('onAdd', function(data) {
                    console.log(data);
                    const user = {id:data.user,name:data.user};
                    self.participants.push(user);
                });

                //update user list
                this.pomelo.on('onLeave', function(data) {
                    console.log(data);
                    for (var i=0; i<self.participants.length; i++) {
                      if (self.participants[i].name === data.user) {
                        self.participants.pop();
                      }
                    }
                    console.log(self.participants);
                });
            },

            sendMessage (text) {
              if (text.length > 0) {
                this.newMessagesCount = this.isChatOpen ? this.newMessagesCount : this.newMessagesCount + 1;
                this.onMessageWasSent({ author: 'support', type: 'text', data: { text } });
              }
            },
            onMessageWasSent (message) {
              // called when the user sends a message
              this.sendOneMessage(message.data.text);
              this.messageList = [ ...this.messageList, message ]
            },
            openChat () {
              // called when the user clicks on the fab button to open the chat
              this.isChatOpen = true
              this.newMessagesCount = 0
            },
            closeChat () {
              // called when the user clicks on the botton to close the chat
              this.isChatOpen = false
            }



        }
    }
</script>