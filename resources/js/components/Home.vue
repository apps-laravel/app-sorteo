<script  setup>
import { Avatar } from 'vue3-avataaars';
</script>

<script>
  import {Factory} from "vue3-avataaars";
  import JSConfetti from 'js-confetti'


  export default {
      data() {
          return {
              name:'Click en el boton para generar sorteo',
              timerEnabled: false,
              countDown: 4,
              props: Factory(),
              listOne: ['LongHairStraight2','LongHairShavedSides'],
              listTwo: ['BlondeGolden','lightBlonde'],
              top: 'LongHairStraight2',
              hairColor: 'BlondeGolden',
              users: [
                  {name: 'Juan', gender:'M'},
                  {name: 'Maria', gender:'F'},
                  {name: 'Pedro', gender:'M'},
                  {name: 'Luis', gender:'M'},
                  {name: 'Ana', gender:'F'},
              ],
              jsConfetti: new JSConfetti(),
          };
      },
      watch: {
            timerEnabled(value) {
                if (value) return this.random();
            },
          countDown: {
              handler(value) {
                  if (value > 0 && this.timerEnabled) return this.random();
                  if (value === 0) {
                      this.timerEnabled = false;
                      this.countDown = 4;
                      this.jsConfetti.addConfetti()
                  }
              },
              immediate: true,
          },
      },
      methods: {
          getRandomUser( ) {
               const {name,gender} = this.users[Math.floor(Math.random() * this.users.length)]
                 this.genderAvatar(gender)
                return this.name = name;
            },
            random() {
                setTimeout(() => {
                    this.countDown--;
                    this.props = Factory()
                    this.getRandomUser()
                }, 400);
            },
          genderAvatar(value) {
              if (value === 'M') {
                  this.top = 'LongHairShavedSides'
                  this.hairColor = 'lightBlonde'
              } else {
                  this.top = 'LongHairStraight2'
                  this.hairColor = 'BlondeGolden'
              }
          },
          start() {
                if(this.users.length >=5) return  this.timerEnabled = true;

          },
      },
  };
</script>

<template>

    <div class="container">

        <div class="d-flex align-items-center flex-column bd-highlight mb-3" >

                <Avatar class="avatar" v-bind="props"
                         :isCircle=true
                         :accessoriesType="'Blank'"
                         :top=top
                         :hairColor=hairColor
                         :clotheType="'BlazerShirt'"
                         :eyeType="'Default'"
                         :facialHair="'Blank'">
                </Avatar>
            <div class="p-2 bd-highlight" >
                <h3>
                    <strong> {{name}}</strong>
                </h3>
            </div>
            <div class="p-2">
                <button class="btn btn-outline-danger"
                        @click="start"
                        :disabled="timerEnabled"
                    >
                    <i class="bi bi-arrow-repeat"></i>
                    Generar Sorteo
                </button>
            </div>

        </div>
    </div>


</template>
<style scoped>
.avatar {
    width: 40vh;
}
</style>


