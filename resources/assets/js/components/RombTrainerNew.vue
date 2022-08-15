<template>
  <div class="View task">

    <div class="View__head">
      <div class="container">
        <div class="row text-center">

          <div class="col-sm-5 text-sm-left">
            <h3 class="View__title mb-sm-0">
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
            v-if="countdownState"
            :class="[
              'task__number task__number--countdown',
              countdownState && 'animated infinite bounceIn'
            ]">
            {{countdownState}}
          </div>

          <div
            v-else-if="isTaskNumberVisible"
            class="task__number">

            <div class="soroban">
                <soroban-row v-for="(numb, i) in curNumbArr" :key="i" :numb="parseInt(numb)"></soroban-row>
            </div>

          </div>
        </div>

        <div class="task__jumbo">
          <div class="row">
            <div v-if="isTaskStopped || isWaitingForAnswer" class="col-md-4">
              <div
                :class="['mate', (isAnimation && isAnswerCorrect) && 'animated tada', (isAnimation && !isAnswerCorrect) && 'animated fall']">
                <img
                  class='mate__picture'
                  src="../../img/pencil.png"
                  alt="карандаш"
                >
                <div class="mate__quote">
                  <img class="mate__cloud" src="../../img/quote.png" alt="текст">
                  <div v-if="modal.title" class="mate__text">{{modal.title}}</div>
                  <div v-else-if="isWaitingForAnswer && runOutOfNums" class="mate__text">Ура! Ты завершил пример!</div>
                  <div v-else-if="isWaitingForAnswer" class="mate__text">Стоп! Время ответа!</div>
                  <div v-else-if="isTaskStopped" class="mate__text">Ну что?<br>Начнём!</div>
                  <div id="countdown" v-else-if="!isTaskStopped && countdownState"
                       :class="['mate__text', countdownState && '']">Обратный отсчёт!
                  </div>
                  <div v-else v-show="!isTaskStopped && !countdownState" class="mate__text">Поехали!
                  </div>
                </div>

              </div>
            </div>

            <div class="col-xs-12 col-md-8">
              <div class="task__result-w">

                <div v-if="showBackToExercisesLink" class="task__result">
                  <button class="task__next" @click="backToExercises">
                    Список заданий
                  </button>
                </div>

                <div v-else-if="isWaitingForAnswer && !this.runOutOfNums" class="task__result">
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
                
              </div>
            </div>

            <div class="col-xs-12 text-center">
              <button v-if="isTaskStopped" class="task__start" @click="runTasks()">Начать</button>
              <div v-if="isWaitingForAnswer && !this.runOutOfNums" class="result">
                <input
                  class="result__text"
                  name="result"
                  type="text"
                  id="result"
                  ref="resultInput"
                  placeholder="Какое число?"
                  v-model="result"
                >
                <button
                  class="result__submit"
                  @click="handleAnswer($event)"
                  :disabled="isProccessingAnswer"
                >
                  Проверить
                </button>
              </div>
            </div>
          </div>
        </div>

      </div><!-- .task__content -->
    </div><!-- .View__body -->
  </div>
</template>

<script>
    import dayjs from 'dayjs'
    import 'animate.css';
    import Sound from './Sound';
    import SorobanRow from './SorobanRow';
    import { generateNumbers } from '../helpers'


  const delay = interval =>
    new Promise(resolve => setTimeout(resolve, interval));

  const MONTHS = { 
    0: 'Январь', 
    1: 'Февраль',
    2: 'Март',
    3: 'Апрель',
    4: 'Май',
    5: 'Июнь',
    6: 'Июль',
    7: 'Август',
    8: 'Сентябрь',
    9: 'Октябрь',
    10: 'Ноябрь',
    11: 'Декабрь',
    }

  export default {
    name: 'RombTrainerNew',
    components: {Sound, SorobanRow},
    props: ['homeTask', 'trainer_name', 'trainer_id', 'student_id', 'task_type'],
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
      isAnimation: false,
      // switchScreenShowed: false,
      // task: {},
      // nextTask: {},
      curNumb: null, // текущее число
      numbersShowed: 0, // кол-во показанных чисел
      runOutOfNums: false, // показаны ли все числа
      isAnswerCorrect: null,
      countdownState: 3,
      isTaskStopped: true,
      isTaskNumberVisible: false, // отображено ли число на экране
      // isTaskSwitching: false,
      speedInputHidden: false, // скрыто ли поле для выбора скорости проигрывания чисел
      // latestSort: null, // значение поля sort последнего примера в списке упражнений
      // isMoreTasks: true, // остались ли ещё примеры(нужно чтобы понять стоить ли делать запрос за следующим примером)
      curNumbArr: [],
      isProccessingAnswer: false,
      // isMoreTasks: true,
      // isLastButOne: false,
      numbers: [],
      userCorrectAnswersCount: 0,
      startedTime: null,
      finishedTime: null,
      leadTime: null,
      points: null,
      accuracy: null,
      showBackToExercisesLink: false,
    }),

    mounted() {
      this.speed.picked = parseFloat(this.homeTask.speed)
      this.setSpeedBoxData();
      this.numbers = generateNumbers(this.homeTask);
    },
    updated() {
    },
    methods: {

      adjustWindowOnMobile() {
        if (window.innerWidth < 2992) {
          $(window).scrollTop(this.$refs.content.offsetTop);
        }
      },

      updateVisualAreaWidth() {
        this.speed.visual = this.speed.step * this.speed.picked;
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
      },

      decrementSpeed() {
        if (this.speed.picked <= 0.1) return;

        this.speed.picked = this.speed.picked > 1
          ? this.speed.picked - 1
          : +(this.speed.picked - 0.1).toFixed(1);
        this.updateVisualAreaWidth();
      },

      async handleAnswer($event) {
        this.adjustWindowOnMobile();
        this.hideNumb();
        
        if (this.$refs.resultInput.value === this.curNumb) {

          this.isAnswerCorrect = true;
          this.userCorrectAnswersCount += 1

        //   this.$refs.refSound.playSuccess();
        
        } else {

          this.isAnswerCorrect = false;

        //   this.$refs.refSound.playLoose();

        }

        this.isAnimation = true;
        this.isProccessingAnswer = true;

        await delay(600);

        this.isProccessingAnswer = false;
        this.isAnimation = false;
        this.result = '';

       this.keepRunningIfNeed();

      },

      updateCurNumb() {
        this.curNumb = this.numbers[this.numbersShowed] + '';
      },

      updateNumbersShowed() {
        this.numbersShowed = this.numbersShowed + 1;
      },

      getCurNumbArr() {
        this.curNumbArr = this.curNumb.split('');
      },

      logError(err) {
        console.log('что-то пошло не так', err);
      },
      revealNumb() {
          this.isTaskNumberVisible = true;
          return delay(this.speed.picked * 1000);
 
      },
      hideNumb() {
        this.isTaskNumberVisible = false;
      },

      showInputForAnswer() {
        this.curNumb = null;
        this.curNumbArr = [];
        this.hideNumb();
      },

      async finishTask() {
        this.runOutOfNums = true;
        this.finishedTime = dayjs()

        function correct(n1, n2) {
          return n2 - n1 * 60
        }

        function formatIfNeeded(n) {
          return n < 10 ? '0' + n : n
        }

        const h = this.finishedTime.diff(this.startedTime, 'hour')
        const m = this.finishedTime.diff(this.startedTime, 'minute')
        const s = this.finishedTime.diff(this.startedTime, 'second')

        this.leadTime = formatIfNeeded(h) + ':' + formatIfNeeded(correct(h, m)) + ':' + formatIfNeeded(correct(m, s))
        this.points = (this.userCorrectAnswersCount * 10).toFixed()
        this.accuracy = (this.userCorrectAnswersCount / this.numbers.length * 100).toFixed() + "%"

        const data = {
          started_time: `${MONTHS[this.startedTime.month()]} ${this.startedTime.date()}, ${this.startedTime.hour()}:${this.startedTime.minute()}`,
          lead_time: this.leadTime,
          points: this.points,
          accuracy: this.accuracy,
          is_finished: 1,
          answers_total: this.numbers.length,
          answers_correct: this.userCorrectAnswersCount,
          answers_wrong: this.numbers.length - this.userCorrectAnswersCount,
          trainer_id: this.trainer_id,
          student_id: this.student_id,
          task_type: this.task_type,
        }

        this.task_type === "group"
          ? data.group_task_id = this.homeTask.id
          : data.student_task_id = this.homeTask.id
          
        await axios
          .post('/api/tasks/results', data)
          .then(response => {
            if(!response.data.updated) {
              alert('К сожалению, не удалось сохранить статистику. Пожалуйста, сообщите администратору.');
            }
          })
          .catch(err => console.log(err))

        this.showBackToExercisesLink = true;
      },

      keepRunningIfNeed() {
        return this.numbersShowed < this.numbers.length
            ? this.runNum()
            : this.finishTask();
      },

      runNum() {
        return new Promise(async (resolve) => {
        this.updateCurNumb();
        this.getCurNumbArr();
        await this.revealNumb();
        // this.$refs.refSound.playTaskBackground();
        this.hideNumb();
        this.updateNumbersShowed();

        resolve();
        })
      },
    
      runNumbers() {
        this.isTaskNumberVisible = true;
        this.runNum();
      },

      decrementCountdownState() {
        this.$refs.refSound.resetSounds();
        this.$refs.refSound.playTick();

        if (this.countdownState == 1) {
          this.countdownState = 'START';
          return;
        }
        if (this.countdownState == 'START') {
          this.countdownState = 0;
          return;
        }
        this.countdownState = this.countdownState - 1;
      },
      runCountdown() {
        this.speedInputHidden = true;

        return delay(1000)
          .then(this.decrementCountdownState)
          .then(this.initStuff)
      },
      initStuff() {
        this.adjustWindowOnMobile();
        this.countdownState === 'START' || this.countdownState > 0 ? this.runCountdown() : this.runNumbers();
      },
      startTask() {
        this.modal.title = '';
        this.runOutOfNums = false;
        // this.$refs.refSound.pauseSounds();
        // this.$refs.refSound.resetSounds();
        this.reset();
        this.isTaskStopped = false;
        this.initStuff();
      },
      runTasks() {
        if(!this.startedTime) {
          this.startedTime = dayjs()
        }
        this.reset();
        this.countdownState = 3;
        this.isTaskStopped = false;
        this.initStuff();
      },
      reset() {
        this.isTaskNumberVisible = false;
        this.curNumb = null;
        this.curNumbArr = [];
        this.numbersShowed = 0;
        this.countdownState = 0;
        this.isTaskStopped = true;
      },

      backToExercises() {
        window.location.pathname = `/student/${this.student_id}/tasks`;
      },
    },
    watch: {
      'speed.picked'(newVal) {
        if (newVal > 10) this.speed.picked = 10;
        if (newVal < 0.1) this.speed.picked = 0.1;
      },
    },

    computed: {
      isWaitingForAnswer() {
        return !!(this.numbersShowed && !this.isTaskNumberVisible)
      }
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
      padding-top: 20px;
      color: #fff;
      font-size: 250px;
      font-family: Muller, ProximaNova, Arial, sans-serif;
      font-weight: 400;
      display: flex;
      align-items: center;

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
      animation-iteration-count: 1;
    }

    &.fall {
      animation-name: fall;
      animation-duration: 500ms;
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
      width: 60%;
      color: #fff;
      padding: 0 60px 0 30px;
      text-align: center;
    }

    &__submit {
      height: 63px;
      width: 60%;
      color: #fff;
      background: #ffc000;
      font-family: 'Caveat', cursive;
      text-transform: uppercase;
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
