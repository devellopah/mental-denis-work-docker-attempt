<template>
  <div class="row generator">
    <div class="col-sm-6">

      <!-- Вступление -->
      <div class="row form-group clearfix">
          <div class="col-md-12">
              <label for="intro" class="">Сообщение</label>
          </div>

          <div class="col-md-12">
              <textarea id="intro" class="generator__intro" v-model="textComputed" spellcheck="false"></textarea>
          </div>
      </div>

      <!-- Уровень -->
      <div class="row form-group clearfix">
        <div class="col-md-6">
          <label for="rules" class="">Уровень</label>
        </div>

        <div class="col-md-6">
          <v-select
            v-model="options.level"
            :searchable="false"
            :options="rules"
            inputId="rules"
          ></v-select>
        </div>
      </div>

      <!-- Обязательные формулы -->
      <div class="row form-group clearfix">
        <div class="col-md-6">
          <label for="requiredFormulas" class="">Обязательные формулы</label>
        </div>

        <div class="col-md-6">
          <v-select
            multiple
            v-model="options.requiredFormulas"
            :options="formulas"
            inputId="requiredFormulas"
            :disabled="!formulas.length"
          ></v-select>
        </div>
      </div>
      <!-- Размер слагаемого -->
      <div class="row form-group clearfix">
        <div class="col-md-6">
          <label for="minmax" class="">Размер слагаемого</label>
        </div>

        <div class="col-md-6">
          <v-select
            v-model="options.minmax"
            :searchable="false"
            :options="options.level === 'прямой счёт к 4' ? direct4minmax: minmax"
            inputId="minmax"
          ></v-select>
        </div>
      </div>

      <!-- Кол-во примеров -->
      <div class="row form-group clearfix">
        <div class="col-md-6">
          <label for="quantity" class="">Кол-во примеров</label>
        </div>

        <div class="col-md-6">
          <number-input
            v-model="options.quantity"
            id="quantity"
            :min="1"
            :max="100"
          ></number-input>
        </div>
      </div>

      <!-- Кол-во чисел в примере -->
      <div class="row form-group clearfix">
        <div class="col-md-6">
          <label for="nums" class="">Кол-во слагаемых</label>
        </div>

        <div class="col-md-6">
          <number-input
            v-model="options.nums"
            id="nums"
            :min="minTaskLen"
            :max="maxTaskLen"
          ></number-input>
        </div>
      </div>

      <!-- Вычитание -->
      <div class="row form-group clearfix" style="display: flex; align-items: center;">
        <label class="col-md-6" style="margin-bottom: 0;">Вычитание</label>
        <div class="col-md-6">
          <label class="checkbox" style="padding: 0;">
            <input
              type="checkbox"
              v-model="options.subtraction"
              :disabled="subtractionNotToggleable"
            />
            <span class="checkbox-material">
              <span class="check"></span>
            </span>
          </label>
        </div>
      </div>

      <div class="row form-group clearfix">
        <div class="col-sm-12">
          <button
            class="btn btn-primary"
            style="color: #444;"
            @click.prevent="run();"
          >
            поехали!
          </button>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="pdf-container">

        <!-- <div class="pdf-loader-container">
            <img src="../../img/loader.gif" alt="loader" class="pdf-loader">
        </div> -->

        <div style="font-size: 16px; font-weight: 400; margin-bottom: 60px;">{{text}}</div>
        <canvas ref="canvas" width="450" height="700" style="display: none;"></canvas>
        <div ref="viewer" style="background:white;"></div>

        <!-- <object
          id="pdf_viewer"
          :data="[pdf ? pdf : intro]"
          width="100%"
          height="100%"
        ></object> -->
      </div>

        <button
          class="btn btn-primary"
          style="color: #444;"
          @click.prevent="drawHTML();"
          v-if="isPDFGeneratorVisible"
        >
          генерация pdf
        </button>
    </div>
    <!-- </div> -->
  </div>
</template>

<script>
import * as rasterizeHTML from 'rasterizehtml';
import jsPDF from 'jspdf';
import _ from 'lodash';
import MobileDetect from 'mobile-detect';

import proximanova from '../fonts';
import Generator from '../generator';
import * as DATA from '../data';
import FORMULASMAP from '../formulas';

const md = new MobileDetect(window.navigator.userAgent);

// :disabled="
//   options.level === 'прямой счёт к 4' ||
//     options.level === 'прямой счёт к 9'
// "

export default {
  name: 'Generator',
  components: {},

  data: () => ({
    text: 'Сообщение для учеников',

    options: {
      min: 1,
      max: 9,
      level: '+1 = +5-4',
      requiredFormulas: [],
      minmax: 'от 1 до 9',
      subtraction: true,
      quantity: 40,
      nums: 4,
    },
    formulas: FORMULASMAP['+1 = +5-4'],
    pdf: null,
    rules: DATA.rules,
    minmax: DATA.minmax,
    direct4minmax: DATA.direct4minmax,
    tasks: [],
    isTasksHtml: false,
    isPDFGeneratorVisible: false,
  }),

  mounted() {

  },

  updated() {},

  computed: {
    rule() {
      const rule = parseInt(this.options.level, 10);
      return Number.isNaN(rule) ? true : rule;
    },
    level() {
      return DATA.levels[this.options.level];
    },
    minTaskLen() {
      return this.level === 'mate' && this.rule < 0 ? 3 : 2;
    },
    maxTaskLen() {
      if (this.options.subtraction) return 10;

      if (this.level === 'direct') {
        if (this.options.level === 'прямой счёт к 4') return 4;
        return 5;
      }

      if (this.level === 'bro' && this.rule > 0) {
        if (this.options.requiredFormulas.length === 1) {
          const requiredRule = parseInt(this.options.requiredFormulas[0], 10);
          if (requiredRule === 1) return 9;
          if (requiredRule === 2) return 8;
          if (requiredRule === 3) return 7;
          if (requiredRule === 4) return 6;
        }

        if (this.rule === 1) return 9;
        if (this.rule === 2) return 8;
        if (this.rule === 3) return 7;
        if (this.rule === 4) return 6;
      }
    },
    subtractionNotToggleable() {
      const { requiredFormulas } = this.options;
      if (this.level === 'bro' && this.rule === 1) return true;
      if (requiredFormulas.some(f => parseInt(f, 10) < 0)) return true;
      if (
        requiredFormulas.length === 2 &&
        DATA.levels[requiredFormulas[0]] === DATA.levels[requiredFormulas[1]]
      )
        return true;
      if (requiredFormulas.length > 2) return true;

      return false;
    },

    levelTaboo() {
      return this.level === 'direct'
        ? [1, -1, 2, -2, 3, -3, 4, -4]
        : DATA[`${this.level}Taboo`][this.options.level];
    },

    ruleColumns() {
      return DATA.ruleColumns[this.options.minmax];
    },

    textComputed: {
      get() {
        return this.text;
      },
      set: _.debounce(function(newValue) {
        this.text = newValue;
      }, 3000)
    },

    intro() {
        const pdf = new jsPDF();

        pdf.addFileToVFS(proximanova.regular.ttf, proximanova.regular.base64);
        pdf.addFont(proximanova.regular.ttf, proximanova.name, proximanova.regular.weight);
        pdf.setFont(proximanova.name);

        pdf.setFontSize(16)
        pdf.text(this.textComputed, 10, 10)

        return pdf.output('datauristring');
    },
  },

  watch: {
    min(val) {
      this.options.nums = val;
    },
    'options.level'(val) {
      this.options.nums = 4;
      this.formulas = FORMULASMAP[val];
      this.options.requiredFormulas = [];

      if (val === 'прямой счёт к 4') this.options.minmax = 'от 1 до 4';
      if (val === 'прямой счёт к 9') this.options.minmax = 'от 1 до 9';

      val === 'прямой счёт к 4'
        ? (this.options.max = 4)
        : (this.options.max = 9);
    },
    'options.requiredFormulas'(list) {
      if (!this.options.subtraction && this.options.nums > 6) {
        if (this.options.requiredFormulas.length === 1) {
          const requiredRule = parseInt(this.options.requiredFormulas[0], 10);

          if (this.isBroPositive(this.options.requiredFormulas[0])) {
            if (requiredRule === 1 && this.options.nums > 9)
              this.options.nums = 9;
            if (requiredRule === 2 && this.options.nums > 8)
              this.options.nums = 8;
            if (requiredRule === 3 && this.options.nums > 7)
              this.options.nums = 7;
            if (requiredRule === 4 && this.options.nums > 6)
              this.options.nums = 6;
          }
        } else if (
          this.options.requiredFormulas.length === 0 &&
          this.level === 'bro' &&
          this.rule > 0
        ) {
          if (this.rule === 1 && this.options.nums > 9) this.options.nums = 9;
          if (this.rule === 2 && this.options.nums > 8) this.options.nums = 8;
          if (this.rule === 3 && this.options.nums > 7) this.options.nums = 7;
          if (this.rule === 4 && this.options.nums > 6) this.options.nums = 6;
        }
      }
      if (list.some(f => parseInt(f, 10) < 0)) this.options.subtraction = true;
      if (list.length > 2) this.options.subtraction = true;
      if (list.length === 2 && DATA.levels[list[0]] === DATA.levels[list[1]])
        this.options.subtraction = true;
    },
    'options.subtraction'(checked) {
      if (!checked) {
        if (this.level === 'direct') {
          this.options.nums = this.maxTaskLen;
        }
      }
      if (this.options.nums > 6) {
        if (!checked && this.level === 'bro' && this.rule > 0) {
          if (this.options.requiredFormulas.length > 0) {
            this.options.nums = this.maxTaskLen;
          } else {
            if (this.rule === 1 && this.options.nums > 9) this.options.nums = 9;
            if (this.rule === 2 && this.options.nums > 8) this.options.nums = 8;
            if (this.rule === 3 && this.options.nums > 7) this.options.nums = 7;
            if (this.rule === 4 && this.options.nums > 6) this.options.nums = 6;
          }
        }
      }
    }
  },

  methods: {
    run() {
      this.$refs.viewer.innerHTML = '';
      this.emptyTasksHtml();

      Promise.resolve(true)
        .then(this.generateTasks)
        .then(this.createTaskHtml)
    },

    async generateTasks() {
      const gen = new Generator(this.options)
      const tasks = await gen.generateTasks()

      this.tasks = tasks;

      // если десктоп, то показать кнопку "генерировать pdf"
      if(!md.mobile()) {
        this.isPDFGeneratorVisible = true;
      }

      return tasks;
    },

    createTaskHtml(list) {
      const html = `
        <div style="margin: auto; text-align: center; max-width: 450px; font-family: ProximaNova, sans-serif; color: #333; font-size: 18px; font-weight: 400;">
            <div style="display: flex; justify-content: center; flex-wrap: wrap">
                ${list
                  .map(task => {
                    return `
                        <div style="width: 20%; margin-bottom: 25px;">
                            <div style=" border: 1px solid #333; width: 60px; line-height: 25px; display: inline-block;">
                            ${task
                              .map(num => {
                                return `
                                    <div style="border-bottom: 1px solid #333;">${num}</div>
                                `.trim()
                              })
                              .join('')}
                            <div style="font-size: 0 !important;">:)</div>
                            </div
                            >
                        </div>`.trim()
                  })
                  .join('')}
            </div>
        </div>
            `

      if(!this.isTasksHtml) {
        this.$refs.viewer.innerHTML += html;
      }

      this.isTasksHtml = true;

      return html;
    },

    emptyTasksHtml() {
      this.isTasksHtml = false;
    },

    async createCanvas(html) {
      const canvas = document.createElement('canvas')
      // const context = canvas.getContext('2d')

      canvas.width = 450
      canvas.height = 700

      // const canvas = this.$refs.canvas

      await rasterizeHTML.drawHTML(html, canvas)

      // await rasterizeHTML.drawHTML(html).then(renderResult => context.drawImage(renderResult.image, 0, 0))

      return canvas
    },

    drawHTML() {

      const { nums } = this.options;
      let k;

      if ([6, 7, 8].indexOf(nums) !== -1) {
        k = 15;
      } else if ([9, 10].indexOf(nums) !== -1) {
        k = 10;
      } else {
        k = 20;
      }

      console.log('k', k);

      const promises = _.chunk(this.tasks, k)
        .map(this.createTaskHtml)
        .map(this.createCanvas);

      Promise.all(promises).then(canvas => this.generatePDF(canvas));
    },

    generatePDF(canvas) {
      const pdf = new jsPDF('p', 'pt', 'a4')

      pdf.addFileToVFS(proximanova.regular.ttf, proximanova.regular.base64)
      pdf.addFont(proximanova.regular.ttf, proximanova.name, proximanova.regular.weight)
      pdf.setFont(proximanova.name)
      pdf.setFontSize(16)

      pdf.text(this.textComputed, 30, 30)


      canvas.forEach((image, i) => {
        console.log('image', image);

        !!i && pdf.addPage() // если не первый элемент, добавляем новую страницу в документ
        pdf.addImage(image.toDataURL(), 'PNG', 80, 80, image.width, image.height) // добавляем изображение на страницу
      })

      pdf.save();
      this.pdf = pdf.output('datauristring')

      // pdf.output('dataurlnewwindow')
    },
  }
};
</script>

<style lang="scss">
canvas {
  height: 700px;
  width: 450px;
}
.v-select .dropdown-toggle .clear {
  display: none !important;
}
.generator {
  padding-bottom: 20px;

  &__intro {
    font-weight: 300;
    font-family: monospace;
    font-size: 18px;
    border: 1px solid rgb(170, 170, 170);
    padding: 10px;
    width: 100%;
  }
}

.pdf-container {
  height: 700px;
  position: relative;
  margin-bottom: 20px;
  overflow: auto;

    &::-webkit-scrollbar-track {
      box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
      background-color: #F5F5F5;
    }

    &::-webkit-scrollbar {
      width: 10px;
      background-color: #F5F5F5;
    }

    &::-webkit-scrollbar-thumb {
      background-color: #444444;
      border: 2px solid #555555;
    }
}

.pdf-loader-container {
  height: 100%;
  width: 100%;
  background: black;
  position: absolute;
  z-index: -1;
}

.pdf-loader {
  position: absolute;
  top: 50%;
  width: 100%;
  transform: translateY(-50%);
}

.v-select {
  .selected-tag {
    font-size: 16px;
  }
}

.number-input__input{
  font-size: 16px !important;
}

</style>
