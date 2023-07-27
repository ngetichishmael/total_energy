// public/js/graph.js

document.addEventListener('livewire:load', function () {
    const graphCanvas = document.getElementById('incomeExpenseGraph').getContext('2d');
    let incomeData = [];
    let expenseData = [];

    Livewire.on('graphData', (data) => {
        incomeData = data.income;
        expenseData = data.expense;

        new Chart(graphCanvas, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: '
