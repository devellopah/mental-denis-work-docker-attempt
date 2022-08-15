<template>
  <div class="View task">

    <div class="View__head">
      <div class="container">
        <div class="row text-center">

          <div class="col-sm-5 text-sm-left">
            <h3 class="View__title mb-sm-0">
              Упражнение: {{task.name}}
            </h3>
          </div>

        </div><!-- .row -->
      </div><!-- .container -->
    </div><!-- .View__head -->

    <div class="View__body">
      <div class="task__content container" ref="content">
        <sound ref="refSound"></sound>
        <div v-if="!isTaskStopped || isTaskNumberVisible" class="task__numbers-screen">
          <div
            v-if="countdownState >= 0 && countdownStateIsVisible"
            :class="[
              'task__number task__number--countdown',
              countdownState >= 0 && 'animated infinite bounceIn'
            ]">
            {{countdownState || 'START'}}
          </div>

          <div v-else-if="isTaskNumberVisible"
            class="task__number">
            {{currentNumber}}
          </div>
        </div>

        <div class="task__header d-none d-md-block">
          <!--<img v-if="isTaskStopped" src="../../img/speed-text.png" alt="">-->
          <h3>Нажимай на старт и решай задачу!</h3>
        </div>

        <div class="task__jumbo">
          <div class="row">
            <div v-if="isTaskStopped || isAllNumbersShowed" class="col-md-4">
              <div
                :class="['mate', (isAnimationShowed && isAnswerCorrect) && 'animated tada', (!this.isAnswerCorrect && this.modal.title && this.isAnimationShowed) && 'animated fall']">
                <img
                  class='mate__picture'
                  src="../../img/pencil.png"
                  alt="карандаш"
                >
                <div class="mate__quote">
                  <img class="mate__cloud" src="../../img/quote.png" alt="текст">
                  <div v-if="modal.title" class="mate__text">{{modal.title}}</div>
                  <div v-else-if="isAllNumbersShowed" class="mate__text">Стоп! Время ответа!</div>
                  <div v-else-if="isTaskStopped" class="mate__text">Ну что?<br>Начнём!</div>
                  <div id="countdown" v-else-if="!isTaskStopped && countdownState"
                       :class="['mate__text', countdownState && '']">Обратный отсчёт!
                  </div>
                  <div v-else v-show="!isTaskStopped && !countdownState" class="mate__text">Поехали!
                  </div>
                </div>

              </div>
            </div>

            <div :class="[isTaskStopped || isAllNumbersShowed ? 'col-md-8' : 'col-xs-12']">
              <div class="task__result-w">
                <!-- <transition name="fade" mode="out-in"> -->
                <div v-if="modal.title" class="task__result">
                  <button class="task__replay" @click="onModalClose">
                    Повторить
                  </button>
                  <button v-if="isMoreTasks" class="task__next" @click="goToNextTask">
                    След. пример
                  </button>
                  <button v-else class="task__next" @click="backToExercises">
                    Список упражнений
                  </button>
                </div>
                <div v-else-if="result" class="task__result">
                  Ответ: {{result}}
                </div>
                <div v-else-if="isTaskStopped && !speedInputHidden" class="task__speed">
                  <h2 class="task__speed-title d-md-none">Нажимай старт и приступай к заданию!</h2>
                  <div class="task__speed-boxWrap">
                    <div
                      id="speedBox"
                      class="task__speed-box"
                      ref="speedBox"
                      @click="updateSpeedData">
                      <div
                        class="task__speed-visual"
                        :style="{width: speed.visual + 'px'}">
                      </div>
                    </div>
                    <div class="task__speed-controls">
                      <div class="task__speed-val">
                        {{speed.picked}} сек
                      </div>
                      <div @click="decrementSpeed" class="task__speed-dec">&#8722;</div>
                      <div @click="incrementSpeed" class="task__speed-inc">&#43;</div>
                    </div>
                  </div>
                </div>

                <div
                  v-else-if="isTaskNumberVisible && isAllNumbersShowed"
                  class="task__result"
                >
                  Ответ:
                </div>
              </div>
            </div>

            <div class="col-xs-12 text-center">
              <button v-if="isTaskStopped" class="task__start" @click="runTasks()">Начать</button>
              <div v-if="isAllNumbersShowed && !modal.title" class="result">
                <input
                  class="result__text"
                  name="result"
                  type="text"
                  id="result"
                  ref="resultInput"
                  placeholder="Введите ответ"
                  v-model="result"
                >
                <button
                  class="result__submit"
                  @click="onResultSubmit($event)"
                >
                  Проверить
                </button>
              </div>
            </div>
          </div>
        </div>

        <!--  <div v-if="switchScreenShowed" class="task__switchscreen">
             START
         </div> -->

      </div><!-- .task__content -->
    </div><!-- .View__body -->
  </div>
</template>

<script>
  // import _debounce from 'lodash/debounce';
  import 'animate.css';
  import Sound from './Sound';

  const delay = interval =>
    new Promise(resolve => setTimeout(resolve, interval));

  const operations = {
    '+': (x, y) => (Number.parseFloat(x) + Number.parseFloat(y)),
    '-': (x, y) => (x - y),
    '*': (x, y) => (x * y),
    '/': (x, y) => (Math.floor(x / y)),
  };

  export default {
    name: 'TrainerTask',
    components: {Sound},
    data: () => ({
      modal: {
        title: '',
        text: '',
        showed: false,
      },
      speed: {
        visual: null,
        step: null,
        picked: null,
      },
      speech: null,
      result: '',
      isAnimationShowed: false,
      switchScreenShowed: false,
      task: {},
      nextTask: {},
      currentNumber: null,
      numbersShowed: 0,
      isAllNumbersShowed: false,
      actualAnswer: null,
      isAnswerCorrect: false,
      countdownState: 3,
      countdownStateIsVisible: false,
      isTaskStopped: true,
      isTaskNumberVisible: false,
      isTaskSwitching: false,
      speedInputHidden: false,
      latestSort: null,
      isMoreTasks: true,
      withSpeech: true,
      rang: null,
    }),
    mounted() {
      axios.get(window.location.href + '/details')
        .then((response) => {
          console.log('response', response);

          this.task = response.data.task;
          this.rang = response.data.rang;
          this.nextTask = response.data.nextTask;
          this.latestSort = response.data.latestSort;
          this.isMoreTasks = !!(this.nextTask && this.nextTask.sort !== this.latestSort);
          this.speed.picked = parseFloat(this.task.speed) || 1;

          console.log('isMoreTasks', this.isMoreTasks);

          this.normalizeOperationsArray();
          this.calcActualAnswer();              
          this.setSpeedBoxData();

          console.log(this.speed)
        })
        .catch(err => console.log('err', err));
    },
    updated() {

    },
    methods: {

      speechSpeak(text) {
          this.speech.text = text;
          // this.speech.lang = 'ru-RU';
          // this.speech.rate = 1;    
          speechSynthesis.speak(this.speech);
      },
      setSpeech(rate){

        const synth = window.speechSynthesis;

        synth.onvoiceschanged = () => {

          console.log('доступные озвучки', window.speechSynthesis.getVoices());

          const lang = "ru-RU";

          const voice = _.find(synth.getVoices(), v => v.lang === lang);

          // if(voice) {
            console.log('выбранная озвучка', voice);
   
            const utterance = new SpeechSynthesisUtterance();
  
            utterance.voice = voice;
            utterance.volume = 1; // 0 to 1
            utterance.rate = rate; // 0.1 to 10
            utterance.pitch = 1; //0 to 2
            utterance.text = '';
            utterance.lang = lang;
  
            this.speech = utterance;
            // this.withSpeech = true;
          // } else {
          //   console.log('к сожалению, озвучки для русского языка не найдено');
          // }

        };
      },
      adjustWindowOnMobile() {
        if (window.innerWidth < 2992) {
          $(window).scrollTop(this.$refs.content.offsetTop);
        }
      },
      normalizeOperationsArray() {
        const operations = this.task.generatedOperations.filter(el => el === '-' || el === '+' || el === '/' || el === '*');
        if (operations.length < this.task.numbers.length) {
          this.task.generatedOperations = ['+', ...operations];
        }
      },
      updateVisualAreaWidth() {
        this.speed.visual = Math.round(this.speed.step * this.speed.picked);
      },
      setSpeedBoxData() {
        this.speed.step = this.$refs.speedBox.clientWidth / 10;
        this.updateVisualAreaWidth();
      },
      updateSpeedData(ev) {
        var offsetX = ev.offsetX;
        var finalOffsetX = offsetX > 0
          ? offsetX > this.speed.step * 10
            ? this.speed.step * 10
            : offsetX
          : 1;

        this.speed.picked = finalOffsetX >= this.speed.step
          ? Math.ceil(finalOffsetX / this.speed.step)
          : Math.ceil(finalOffsetX / this.speed.step * 10) / 10;

        this.updateVisualAreaWidth();
      },
      incrementSpeed() {
        if (this.speed.picked > 10) return;

        this.speed.picked = this.speed.picked >= 1
          ? this.speed.picked + 1
          : +(this.speed.picked + 0.1).toFixed(1);
        this.updateVisualAreaWidth();

        console.log('speed', this.speed);
      },
      decrementSpeed() {
        if (this.speed.picked <= 0.1) return;

        this.speed.picked = this.speed.picked > 1
          ? this.speed.picked - 1
          : +(this.speed.picked - 0.1).toFixed(1);
        this.updateVisualAreaWidth();
      },
      onModalClose() {
        this.$refs.refSound.pauseSounds();
        this.$refs.refSound.resetSounds();
        this.reset();
        this.isAllNumbersShowed = false;
        this.speedInputHidden = true;
        this.isTaskStopped = true;
        this.modal.title = "";
      },
      calcActualAnswer() {
        this.actualAnswer = this.task.numbers.reduce((prev, cur, i) =>
          [prev, cur].reduce(operations[this.task.generatedOperations[i]]), 0
        );
      },
      onResultSubmit($event) {
        this.adjustWindowOnMobile();
        const success = {
          title: 'Молодец! Отлично справился!',
          showed: false,
          text: this.nextTask
            ? 'Вы успешно справились с примером!'
            : 'Введеный результат верный, вы успешно завершили упражнение!'
        };

        const failure = {
          title: 'Неверно, попробуй ещё раз!',
          showed: false,
          text: 'Введеный результат не верный, попробуйте ещё раз!'
        };

        this.result = null;
        this.actualAnswer = null;
        this.calcActualAnswer();

        let stats = {};

        if (this.$refs.resultInput.value == this.actualAnswer) {
          stats = { isCorrectAnswer: true, trainer_id: this.task.trainer_id };

          this.isAnswerCorrect = true;
          this.modal = success;
          this.$refs.resultInput.value = '';
          this.isTaskNumberVisible = false;
          this.$refs.refSound.playSuccess();
          this.speedInputHidden = true;
          this.isAnimationShowed = true;

          setTimeout(() => {
            this.isAnimationShowed = false;
            this.modal.showed = false;
          }, 2000);


        } else {
          stats = { isCorrectAnswer: false, trainer_id: this.task.trainer_id };

          this.isAnimationShowed = true;
          this.isAnswerCorrect = false;
          this.modal = failure;
          this.$refs.refSound.playLoose();
          setTimeout(() => {
            this.isAnimationShowed = false;
          }, 2000);
        }

        if(this.rang === "E") {
          axios.post(`/trainers/${this.trainer_id}/categories/${this.category_id}/exercises/${this.exercise_id}/trainer_task/${this.task.id}/stats`, stats)
          .then(function (response) {
            console.log(response);
          });
        }
      },
      showSwitchScreen() {
        this.switchScreenShowed = true;
        setTimeout(() => {
          if (this.nextTask) {
            const { speed, trainer_id, category_id, exercise_id } = this.task;
            
            this.speedInputHidden = true;
            this.task = this.nextTask;
            this.task.speed = speed;
            this.startTask();
            this.switchScreenShowed = false;
            axios.get(`/trainers/${trainer_id}/categories/${category_id}/exercises/${exercise_id}/task/${this.task.id}/next`)
              .then((response) => this.nextTask = response.data);
          }
        }, 1000)

      },
      updateCurrentNumber() {
        this.currentNumber = this.getOperation(this.numbersShowed)
          + this.task.numbers[this.numbersShowed];
        this.numbersShowed = this.numbersShowed + 1;
      },
      logError(err) {
        console.log('что-то пошло не так', err);
      },
      showNumber() {
        return new Promise(resolve => {
          this.isTaskNumberVisible = true;
          if(this.withSpeech) this.speechSpeak(this.currentNumber);
          resolve();
        });
      },
      hideNumber() {
        this.isTaskNumberVisible = false;
      },
      decideNextStep() {
        this.numbersShowed < this.task.numbers.length
          ? this.handleRestNumbers()
          : delay(this.speed.picked * 800)
            .then(() => {
              this.isAllNumbersShowed = true;
              this.currentNumber = null;
            })
      },
      revealNext() {
        // return delay(this.withSpeech ? 1: this.speed.picked * 1000)
        return delay(this.speed.picked * 1000)
          .then(this.hideNumber)
          .then(() => delay(100))
          .then(this.updateCurrentNumber)
          .then(this.showNumber)
          .then(() => {

          if(!this.withSpeech) {
            this.$refs.refSound.resetSounds();
            this.$refs.refSound.playTick();
          }
            const date = new Date();
          })
      },
      async handleRestNumbers() {
        await this.revealNext();
        if(this.withSpeech) this.speech.onend = this.decideNextStep;
        else this.decideNextStep();
      },
      getOperation(index = 0) {
        return this.task.generatedOperations[index];
      },
      revealFirstNumber() {
        return new Promise(resolve => {
          this.isTaskNumberVisible = true;
          // this.$refs.refSound.playTaskBackground();
          this.updateCurrentNumber();
          this.showNumber();
          resolve();
        })
      },
      async runNumbers() {
        this.countdownStateIsVisible = false;
        await delay(1000);
        await this.revealFirstNumber();
        if(this.withSpeech) this.speech.onend = this.handleRestNumbers;
        else this.handleRestNumbers();
      },
      async proceedCountdown() {
        this.$refs.refSound.resetSounds();
        this.$refs.refSound.playTick();

        this.countdownState = this.countdownState - 1;

        await delay(1000);

        this.countdownState > 0 ? this.proceedCountdown() : this.runNumbers();
      },

      runCountdown() {
          this.startCountdown()
          .then(this.proceedCountdown);
      },

      startCountdown() {
        this.countdownStateIsVisible = true;
        this.$refs.refSound.resetSounds();
        this.$refs.refSound.playTick();

        return delay(1000);
      },

      initStuff() {
        this.adjustWindowOnMobile();

        delay(1000).then(this.runCountdown);
      },
      startTask() {
        this.modal.title = '';
        this.isAllNumbersShowed = false;
        this.$refs.refSound.pauseSounds();
        this.$refs.refSound.resetSounds();
        this.reset();
        if (!this.isTaskSwitching) this.isTaskStopped = false;
        this.initStuff();
        this.normalizeOperationsArray();
      },
      runTasks() {
        this.reset();
        this.normalizeOperationsArray();
        this.countdownState = 3;
        if (!this.isTaskSwitching)
          this.isTaskStopped = false;

        if(this.withSpeech) {
          if(this.speed.picked >= 2) this.setSpeech(1);
          else if(this.speed.picked === 1) this.setSpeech(5);
          else this.withSpeech = false;
        }
        this.initStuff();
      },
      reset() {
        this.isTaskNumberVisible = false;
        this.currentNumber = null;
        this.numbersShowed = 0;
        this.countdownState = 0;
        if (!this.isTaskSwitching)
          this.isTaskStopped = true;
      },
      goToNextTask() {
        this.$refs.refSound.pauseSounds();
        this.$refs.refSound.resetSounds();

        const { speed, trainer_id, category_id, exercise_id } = this.task;

        this.reset();
        this.isAllNumbersShowed = false;
        this.speedInputHidden = true;
        this.isTaskStopped = true;
        this.modal.title = "";
        this.task = this.nextTask;
        this.task.speed = speed;
        this.normalizeOperationsArray();

        window.history.pushState({}, 'Упражнение', `/trainers/${trainer_id}/categories/${category_id}/exercises/${exercise_id}/trainer_task/${this.task.id}`);

        axios.get(`/trainers/${trainer_id}/categories/${category_id}/exercises/${exercise_id}/trainer_task/${this.task.id}/next`)
          .then((response) => {
            console.log('response', response);
            this.nextTask = response.data;
            this.isMoreTasks = this.nextTask.sort !== this.latestSort;
            console.log('isMoreTasks', this.isMoreTasks);
          });
      },
      backToExercises() {
        window.location.pathname = `/trainers/${this.task.trainer_id}/categories/${this.task.category_id}/exercises/${this.task.exercise_id}/trainer_task`;
      }
    },
    watch: {
      'speed.picked'(newVal) {
        if (newVal > 10) this.speed.picked = 10;
        if (newVal < 0.1) this.speed.picked = 0.1;
      },
    },
  }
</script>

<style lang="scss">

  .d-none {
    display: none !important;
  }

  @media screen and (min-width: 992px) {
    .d-md-block {
      display: block !important;
    }

    .d-md-none {
      display: none !important;
    }
  }

  @keyframes fall {
    0% {
      transform-origin: top left;
      animation-timing-function: ease-in-out;
    }

    to {
      transform: translate3d(0, 700px, 0);
      opacity: 0;
    }
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
  }

  .fade-enter, .fade-leave-to {
    opacity: 0;
  }

  .task {

    &__header {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    &__content {
      min-height: 100vh;
      text-align: center;
      color: rgba(20, 127, 203, 0.9);
      background: #0188c5;
      padding-top: 60px;
      padding-bottom: 60px;
      border: 6px solid #95ee94;
      position: relative;

      @media screen and (min-width: 992px) {
        height: 620px;
        min-height: auto !important;
      }
    }

    &__result {
      max-width: 525px;
      min-height: 220px;
      color: #fff;
      font-size: 80px;
      font-weight: 600;
      line-height: 1;
      text-align: center;
      margin: 30px auto 0;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;

      @media screen and (min-width: 992px) {
        font-size: 100px;
        margin-left: 150px;
      }
    }

    &__replay,
    &__next {
      height: 66px;
      width: 250px;
      color: #212121;
      background: #95ee94;
      font-size: 24px;
      font-weight: 400;
      line-height: 66px;
      text-align: center;
      margin: 5px;
      border: 0;
      border-radius: 50px;
      display: block;
      transition: all .2s;

      &:hover {
        color: #333;
        background: #fff;
      }
    }

    &__jumbo {

      @media screen and (min-width: 992px) {
        height: 490px;
        margin-top: 100px;
      }
    }

    &__numbers-screen {
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    &__number {
      color: #fff;
      font-size: 250px;
      font-family: Muller, ProximaNova, Arial, sans-serif;
      font-weight: 400;

      &--countdown {
        color: #95ee94;
        animation-duration: 1s !important;
      }
    }

    &__speed {
      margin-top: 35px;
      margin-bottom: 50px;
      display: flex;
      flex-wrap: wrap;
      align-items: flex-end;
      justify-content: center;

      @media screen and (min-width: 992px) {
        margin-top: 100px;
      }

      &-title {
        color: #fff;
        font-size: 32px;
        font-weight: 600;
        text-transform: uppercase;
        font-family: 'Caveat', cursive;
        margin-bottom: 35px;
      }

      &-boxWrap {
        width: 100%;
        display: flex;
        align-items: flex-end;
        justify-content: center;
      }

      &-box {
        width: 100%;
        max-width: 374px;
        height: 85px;
        background: transparent;
        border: 2px solid #ffbb3b;
        position: relative;
        overflow: hidden;
      }

      &-visual {
        width: 50px;
        background: #ffbb3b;
        transition: width .1s ease-in;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
      }

      &-controls {
        width: 70px;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        margin-left: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;

        @media screen and (min-width: 768px) {
          font-size: 18px;
        }
      }

      &-val {
        width: 100%;
        height: 47px;
        line-height: 47px;
        background: #ffbb3b;
        margin-bottom: 5px;
      }

      &-inc,
      &-dec {
        width: 20px;
        height: 20px;
        line-height: 20px;
        background: #ffbb3b;
        border-radius: 50%;
        cursor: pointer;
      }
    }

    &__start {
      width: 205px;
      height: 63px;
      color: #fff;
      background: #ffc000;
      font-size: 25px;
      font-family: 'Caveat', cursive;
      border: 0;
      border-radius: 30px;
      text-transform: uppercase;
      cursor: pointer;

      &:hover {
        color: #ffc000;
        background: #fff;
      }
    }
  }

  .mate {
    font-size: .7rem;
    display: inline-block;
    margin: auto;
    position: relative;

    @media screen and (min-width: 460px) {
      font-size: 1rem;
    }

    &.tada {
      animation-iteration-count: 3;
    }

    &.hinge {
      animation-duration: 2500ms;
    }

    &.fall {
      animation-name: fall;
      animation-duration: 2000ms;
    }

    &__quote {
      position: absolute;
      top: 125px;
      right: -55px;

      @media screen and (min-width: 460px) {
        top: 100px;
        right: -115px;
      }
    }

    &__cloud {
      width: 20em;
    }

    &__text {
      width: 100%;
      font-size: 3.6em;
      line-height: .8em;
      color: #444;
      font-family: 'Caveat', cursive;
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      top: 0;
      bottom: 0;
    }
  }

  .result {
    font-size: 18px;
    display: inline-flex;
    justify-content: center;

    &__text {
      border: 2px solid #ffc000;
      background: transparent;
      border-radius: 30px;
      height: 63px;
      width: 206px;
      width: 60%;
      color: #fff;
      padding: 0 80px 0 20px;
      padding: 0 60px 0 30px;
      text-align: center;
    }

    &__submit {
      height: 63px;
      width: 206px;
      width: 60%;
      color: #fff;
      background: #ffc000;
      font-family: 'Caveat', cursive;
      text-transform: uppercase;
      margin-left: -70px;
      margin-left: -50px;
      border: 0;
      border-radius: 30px;

      &:hover {
        color: #ffc000;
        background: #fff;
      }
    }
  }

  #countdown {
    animation-duration: 1s;
  }

  @media screen and (max-width: 768px) {
    .task__number--countdown {
      font-size: 75px;
    }
  }
</style>
