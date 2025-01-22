<?php declare(strict_types=1);

namespace Pyz\Yves\SnapFind\Form;

use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \Pyz\Yves\SnapFind\SnapFindConfig getConfig()
 */
class ImageUploadForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_IMAGE = 'image';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addImageField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    private function addImageField(FormBuilderInterface $builder): self
    {
        $builder->add(static::FIELD_IMAGE, FileType::class, [
            'required' => true,
            'label' => 'snapfind.image',
        ]);

        return $this;
    }
}
