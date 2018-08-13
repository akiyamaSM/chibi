{{ $name }} is {{ $age }}

@when($age == 26)
   NO true
@or(3 == 1)
    Should not Entre
@otherwise
    Here
@end