<template>
  <div class="row">
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
            :options="minmax"
            inputId="minmax"
            :disabled="
              options.level === 'прямой счёт к 4' ||
                options.level === 'прямой счёт к 9'
            "
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
            :max="20"
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
      <div class="pdf-loader-container">
          <img src="../../img/loader.gif" alt="loader" class="pdf-loader">
      </div>
        <object
          id="pdf_viewer"
          :data="[pdf ? pdf : intro]"
          width="100%"
          height="100%"
        ></object>
      </div>
    </div>
    <!-- </div> -->
  </div>
</template>

<script>
import * as rasterizeHTML from 'rasterizehtml';
import jsPDF from 'jspdf';
import _ from 'lodash';

import proximanova from '../fonts';
import Generator from '../generator';
import * as DATA from '../data';
import FORMULASMAP from '../formulas';

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
      quantity: 20,
      nums: 4
    },
    formulas: FORMULASMAP['+1 = +5-4'],
    pdf: null,
    rules: DATA.rules,
    minmax: DATA.minmax
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
      Promise.resolve(true)
        .then(this.generateTasks)
        .then(this.drawHTML)

    },

    generateTasks() {
      const gen = new Generator(this.options)
      const tasks = gen.generateTasks()
      return tasks;

    },

    createTaskHtml(list) {
      return `
        <div style="max-width: 435px; margin: auto;">
            <div style="display: flex; justify-content: center; flex-wrap: wrap">
                ${list
                  .map(task => {
                    return `
                        <div style="width: 20%; text-align: center; margin-bottom: 25px;">
                            <div style=" border: 1px solid #333; width: 60px; color: #333; font-size: 18px; line-height: 25px; font-weight: 400; display: inline-block;">
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
    },

    async createCanvas(html) {
      const canvas = document.createElement('canvas')

      canvas.width = 435
      canvas.height = 900

      await rasterizeHTML.drawHTML(html, canvas)

      return canvas
    },

    drawHTML(tasks) {

      const { nums } = this.options;
      let k;

      if ([6, 7, 8].indexOf(nums) !== -1) {
        k = 15;
      } else if ([9, 10].indexOf(nums) !== -1) {
        k = 10;
      } else {
        k = 20;
      }

      const promises = _.chunk(tasks, k)
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
        !!i && pdf.addPage() // если не первый элемент, добавляем новую страницу в документ
        pdf.addImage(image.toDataURL(), 'PNG', 80, 80, image.width, image.height) // добавляем изображение на страницу
      })

      this.pdf = pdf.output('datauristring')
    },
  }
};
</script>

<style lang="scss">
.v-select .dropdown-toggle .clear {
  display: none !important;
}
.generator {
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
  height: 750px;
  position: relative;
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

.number-input__input[data-v-607416cd]{
    font-size: 16px !important; 
    color: #333333 !important; 
    padding: 8px !important;
}

</style>
