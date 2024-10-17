<div>
    @foreach($results as $result)
        <x-dashboard.motor-occasion.list-item :result="\App\Data\MotorOccasion\Result::from($result)" />
    @endforeach
</div>
