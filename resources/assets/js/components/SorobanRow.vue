<template>
    <div class="soroban__row">
		<div class="soroban__cell-w">
			<div :class="['soroban__cell soroban__cell--five', [5, 6, 7, 8, 9].indexOf(numb) !== -1 && 'soroban__cell--filled']"></div>
		</div>
		<div class="soroban__cell-w">
			<div :class="['soroban__cell soroban__cell--one', [1, 2, 3, 4, 6, 7, 8, 9].indexOf(numb) !== -1 && 'soroban__cell--filled']"></div>
		</div>
		<div class="soroban__cell-w">
			<div :class="['soroban__cell soroban__cell--two', [2, 3, 4, 7, 8, 9].indexOf(numb) !== -1 && 'soroban__cell--filled']"></div>
		</div>
		<div class="soroban__cell-w">
			<div :class="['soroban__cell soroban__cell--three', [3, 4, 8, 9].indexOf(numb) !== -1 && 'soroban__cell--filled']"></div>
		</div>
		<div class="soroban__cell-w">
			<div :class="['soroban__cell soroban__cell--four', [4, 9].indexOf(numb) !== -1 && 'soroban__cell--filled']"></div>
		</div>
	</div>
</template>

<script>
export default {
    name: 'SorobanRow',
    props: ['numb'],
}
</script>

<style lang="scss">
.soroban {
	display: inline-flex;
	
	&__row {
		margin: 0 20px;
	}

	&__cell-w {
		margin-bottom: 27px;
	}
	&__cell {
		width: 75px;
		height: 75px;
		border: 3px solid white;
		transform: rotate(45deg);
		
		&--five {
			position: relative;
			&:after {
				content: '';
				position: absolute;
				bottom: -4px;
				height: 5px;
				width: 100%;
				background-color: white;
				transform: rotate(-45deg);
			}
		}
		
		&--filled {
			background-color: #ffbb3b;
		}
	}

}

</style>
