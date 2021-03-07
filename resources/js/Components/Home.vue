<template>
    <div id="home">
        <form @submit.prevent="onJoin">
            <input type="text" ref="inputUser" placeholder="Enter your username.." v-model="currentUser" v-if="jwtToken === ''">
            <button @click="reload" v-else>Logout</button>
        </form>
        <h1 v-if="jwtToken"> This window user: {{ currentUser }}</h1>
        <h2>Logged users list:</h2>
        <ul v-if="users.length">
            <li v-for="(u, index) in users" :key="index">{{ u.name }}</li>
        </ul>
        <p v-else>Enter username to join the list</p>
    </div>
</template>


<script>
import axios from "axios";
export default {
    data() {
        return {
            jwtToken: '',
            currentUser: '',
            users: []
        }
    },
    methods: {
        listenForBroadcast() {
            // metoda koja dodaje jwt token u request koji ide na pusher-u
            let token = this.jwtToken || "token";
            console.log("TOKEN?", token)
            if(token !== 'token') {
                Echo.connector.pusher.config.auth.headers['Authorization'] = `Bearer ${token}`
              try {
                this.authChannel();
              } catch (e) {             }
            }
        },
        authChannel() {
            //Konekcija na channel
            Echo.join('auth')
                .here((users) => {
                    console.log("HEREHERE AUTH C", users);
                    //  Ovde se prikazuju svi ulogovani porisnici i smestaju se u users da bi mogli da se prikazu u listi
                    //  here se poziva kada se korisnik uloguje
                    this.users = users
                })
                .joining((user) => {
                    console.log("JOIN AUTH CH", user);
                    // joining se poziva kada korisnik koji je vec povezan na kanal
                    // dobije signal da se neka druga osoba ulogovala
                    this.users.push(user)
                })
                .leaving((user) => {
                    // leaving se poziva kod svih korisnika i svi dobijaju informaciju da je neko izasao iz kanala
                    // I zato se ovde filrira korisnik koji je ulogovan
                    console.log('LEAVE AUTH C', user);
                    let userToDelete = this.users.find(u => u.id === user.id);
                    let indexOfUser = this.users.indexOf(userToDelete);

                    if(indexOfUser !== -1) this.users.splice(indexOfUser, 1);
                })
        },
        onJoin(){
            //Na klik dugmeta, pokusava se login, ako je login uspeo jwt
            // se dodaje u jwtToken polje i poziva se listenForBroadcast()
            let credentials = {
                email: this.currentUser + '@gmail.com',
                password: 'Admin45!'
            }
            axios.post('/auth/login', credentials)
                .then(({ data }) => {
                    this.jwtToken = data.access_token
                    this.listenForBroadcast();
                })
                .catch(e => {
                    alert("WRONG MAIL")
                    console.log("ERROR", e)
                })
        },
        reload() {
            document.location.reload();
        }
    },
    mounted() {
        this.$refs.inputUser.focus()
    },
    beforeDestroy() {
        // Izlazak iz kanala auth
        Echo.leave('auth');
    }
}
</script>
<style scoped lang="scss">
    #home {
        width: 800px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-top: 100px;
}
    button {
        width: 300px;
        height: 50px;}
    input {
        width: 100%;
        height: 50px;
        font-size: 20px;
        margin-bottom: 40px;}
    h1 {font-size: 40px;}
    h2 {font-size: 55px;}
    p, li {font-size: 30px}
</style>
