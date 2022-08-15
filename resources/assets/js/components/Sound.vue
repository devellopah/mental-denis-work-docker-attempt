<template>
    <div>
        <i class="material-icons volume__icon" v-if="enabled" @click="toggleSound()">volume_up</i>
        <i class="material-icons volume__icon disabled" v-if="!enabled" @click="toggleSound()">volume_mute</i>
        <audio preload ref="successSound" src="/sounds/success.mp3" autostart="false"></audio>
        <audio preload ref="looseSound" src="/sounds/loose.mp3" autostart="false"></audio>
        <audio preload ref="tickSound" src="/sounds/tick.mp3" autostart="false"></audio>
        <audio preload ref="taskBackground" src="/sounds/task_background.mp3" autostart="false"></audio>
    </div>
</template>
<script>
  export default {
    name: 'Sound',
    data() {
      return {
        enabled: true,
        lastSound: '',
      }
    },
    methods: {
      toggleSound() {
        this.enabled = !this.enabled;
        if (!this.enabled) {
          this.$refs.looseSound.volume = 0;
          this.$refs.successSound.volume = 0;
          this.$refs.tickSound.volume = 0;
          this.$refs.taskBackground.volume = 0;
        }
        if (this.enabled) {
          this.$refs.looseSound.volume = 1;
          this.$refs.successSound.volume = 1;
          this.$refs.tickSound.volume = 1;
          this.$refs.taskBackground.volume = 1;
        }
      },
      resetSounds() {
        this.$refs.looseSound.currentTime = 0;
        this.$refs.successSound.currentTime = 0;
        this.$refs.tickSound.currentTime = 0;
        this.$refs.taskBackground.currentTime = 0;
        this.lastSound = false;
      },
      pauseSounds() {
        this.$refs.looseSound.pause();
        this.$refs.successSound.pause();
        this.$refs.tickSound.pause();
        this.$refs.taskBackground.pause();
      },
      playTick() {
        this.pauseSounds();
        this.resetSounds();
        this.lastSound = this.$refs.tickSound;
        this.lastSound.currentTime = 0.3;
        this.lastSound.play();
      },
      playLoose() {
        this.pauseSounds();
        this.resetSounds();
        this.lastSound = this.$refs.looseSound;
        this.lastSound.play();
      },
      playSuccess() {
        this.pauseSounds();
        this.resetSounds();
        this.lastSound = this.$refs.successSound;
        this.lastSound.play();
      },
      playTaskBackground() {
        this.pauseSounds();
        this.resetSounds();
        this.lastSound = this.$refs.taskBackground;
        this.lastSound.play();
      },
    }
  }
</script>

<style>
    .volume__icon {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        color: #fff;
        font-size: 50px;
        z-index: 5000;
    }

    .volume__icon.disabled {
        color: red;
    }
</style>