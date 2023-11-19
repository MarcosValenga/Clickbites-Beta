<?php

namespace App\sistcb\Controllers\nutricionistas;

if (!defined('CL1K3B1T35')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar Perfil, imagem do Perfil e senha do perfil
 * @author Marcos <marcosvalenga360@gmail.com>
 */
class EditProfile
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendEditProfile'])) {
            $this->editProfile();
        } elseif (!empty($this->dataForm['SendEditProfImage'])) {
            $this->editProfImage();
        } elseif (!empty($this->dataForm['SendEditProfPass'])) {
            $this->editProfPass();
        } else {
            $this->loadProfile();
        }
    }

    private function loadProfile(): void
    {
        $viewProfile = new \App\sistcb\Models\nutricionistas\SistcbEditProfile();
        $viewProfImg = new \App\sistcb\Models\nutricionistas\SistcbEditProfileImage();
        $viewProfPass = new \App\sistcb\Models\nutricionistas\SistcbEditProfilePassword();

        $viewProfile->viewProfile();
        $viewProfImg->viewProfile();
        $viewProfPass->viewProfile();

        if ($viewProfile->getResult() && $viewProfImg->getResult() && $viewProfPass->getResult()) {
            $this->data['form']['profile'] = $viewProfile->getResultBd();
            $this->data['form']['image'] = $viewProfImg->getResultBd();
            $this->data['form']['password'] = $viewProfPass->getResultBd();
            $this->viewEditProfile();
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewEditProfile(): void
    {
        $loadView = new \Core\ConfigView("sistcb/Views/nutricionistas/editProfile", $this->data);
        $loadView->loadViewNutricionista();
    }

    private function editProfile(): void
    {
        unset($this->dataForm['SendEditProfile']);
        $editProfile = new \App\sistcb\Models\nutricionistas\SistcbEditProfile();
        $editProfile->update($this->dataForm);

        if ($editProfile->getResult()) {
            $urlRedirect = URLADM . "view-profile/index/" . $_SESSION['user_id'];
            header("Location: $urlRedirect");
        } else {
            $this->data['form']['profile'] = $this->dataForm;
            $this->viewEditProfile();
        }
    }

    private function editProfImage(): void
    {
        unset($this->dataForm['SendEditProfImage']);
        $this->dataForm['new_image'] = $_FILES['new_image'] ? $_FILES['new_image'] : null;
        $editProfImg = new \App\sistcb\Models\nutricionistas\SistcbEditProfileImage();
        $editProfImg->update($this->dataForm);

        if ($editProfImg->getResult()) {
            $urlRedirect = URLADM . "view-profile/index";
            header("Location: $urlRedirect");
        } else {
            $this->data['form']['image'] = $this->dataForm;
            $this->viewEditProfile();
        }
    }

    private function editProfPass(): void
    {
        unset($this->dataForm['SendEditProfPass']);
        $editProfPass = new \App\sistcb\Models\nutricionistas\SistcbEditProfilePassword();
        $editProfPass->update($this->dataForm);

        if ($editProfPass->getResult()) {
            $urlRedirect = URLADM . "view-profile/index/" . $_SESSION['user_id'];
            header("Location: $urlRedirect");
        } else {
            $this->data['form']['password'] = $this->dataForm;
            $this->viewEditProfile();
        }
    }
}
