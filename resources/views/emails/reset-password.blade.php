<x-mail::message>

Olá, {{ $notifiable->name }}!

Recebemos uma solicitação para redefinir a senha da sua conta no **CineBox**.

Se foi você quem solicitou, clique no botão abaixo para criar uma nova senha:

<x-mail::button :url="$url" color="primary">
Redefinir minha senha
</x-mail::button>

<div style="border-left: 4px solid #7c3aed; background-color: #faf5ff; border-radius: 0 6px 6px 0; padding: 14px 16px; margin: 21px 0; font-size: 15px; color: #52525b;">
    Este link é válido por <strong>60 minutos</strong> a partir do momento em que foi gerado.
</div>

Se você não solicitou a redefinição de senha, pode ignorar este e-mail com segurança. Sua conta continua protegida.

— Equipe CineBox

@slot('subcopy')
Se você está tendo problemas para clicar no botão "Redefinir minha senha", copie e cole a URL abaixo no seu navegador:
<span class="break-all">[{{ $url }}]({{ $url }})</span>
@endslot

</x-mail::message>