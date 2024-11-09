<!-- resources/views/trips/breakdown.blade.php -->
<div class="breakdown-details">
    <h4>Breakdown for Day {{ $day }}</h4>
    <p><strong>Activities:</strong> {{ $activitiesTotal }} {{ $currency }}</p>
    <p><strong>Accommodation:</strong> {{ $accommodationTotal }} {{ $currency }}</p>
    <p><strong>Transport:</strong> {{ $transportTotal }} {{ $currency }}</p>
    <p><strong>Flights:</strong> {{ $flightTotal }} {{ $currency }}</p>
    <p><strong>Total Cost for Day:</strong> {{ $totalDayCost }} {{ $currency }}</p>
</div>
