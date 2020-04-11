<tr>
  <td class="header">
      <a href="{{ $url }}" class="logo-img">
        <img height="40px" alt="Logo ajarbelajar.com" src="{{secure_asset('img/logo/logo.svg')}}" />
      </a>
      <br>
      <a href="{{ $url }}" class="logo-text">
        {{ $slot }}
      </a>
  </td>
</tr>
