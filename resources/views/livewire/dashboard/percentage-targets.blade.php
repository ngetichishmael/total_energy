<div class="col-12">
   <div class="col-md-12">
       <div class="row">
           <div class="col-md-12">
               <div class="col-md-12">
                  <div style="height: 400px; width:400px;">
                     <canvas id="myChart" width="200" height="200"></canvas>
                 </div>
               </div>
           </div>
       </div>
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let labels = <?php echo json_encode($salestarget); ?>;
    let Targets = <?php echo json_encode($Targets); ?>;
    let TargetAchieved = <?php echo json_encode($TargetAchieved); ?>;
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: `${labels}`.split(','),
            datasets: [{
                label: 'Ranges',
                data: [`${Targets}`,`${TargetAchieved}`],
                backgroundColor: [
                   '#f07f21',
                   '#35827b'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
            }]
        },
        options: {
            plugins: {
            title: {
                display: true,
                text: 'Sales Per Month'
            }
        }
        }
    });
</script>
