<?php

namespace Cmrweb\AddressBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

class AddressComponentCommand  extends AbstractMaker
{
    private string $namespace = 'Twig\\Components';

    public function __construct() {}

    public static function getCommandName(): string
    {
        return 'make:address-component';
    }

    public static function getCommandDescription(): string
    {
        return 'Create Address Live component';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->setDescription(self::getCommandDescription()) 
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $name = '\\'.$this->namespace."SearchAddress";

        if (!class_exists(AsLiveComponent::class)) {
            throw new \RuntimeException('You must install symfony/ux-live-component to create a Live component (composer require symfony/ux-live-component)');
        } 
        $factory = $generator->createClassNameDetails(
            $name,
            str_replace($generator->getRootNamespace().'\\', '', $this->namespace),
        );

        $templatePath = str_replace('\\', '/', $factory->getRelativeNameWithoutSuffix());
        $shortName = str_replace('\\', ':', $factory->getRelativeNameWithoutSuffix());

        $generator->generateClass(
            $factory->getFullName(),
            \sprintf('%s/templates/twig/%s', \dirname(__DIR__, 2), 'LiveComponent.tpl.php'),
        );
        $generator->generateTemplate(
            "components/{$templatePath}.html.twig",
            \sprintf('%s/templates/twig/%s', \dirname(__DIR__, 2), 'component_template.tpl.php')
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
        $io->newLine();
        $io->writeln(" To render the component, use <fg=yellow><twig:{$shortName} /></>.");
        $io->newLine();
    }
    public function interact(InputInterface $input, ConsoleStyle $io, Command $command): void
    {
        $fileManager = new Filesystem;

        $path = 'config/packages/twig_component.yaml';

        if (!$fileManager->exists($path)) {
            return;
        }

        try {
            $value = Yaml::parse($fileManager->readFile($path));
            $this->namespace = array_key_first($value['twig_component']['defaults']);
        } catch (\Throwable $throwable) {
            throw new RuntimeCommandException(message: 'Unable to parse config/packages/twig_component.yaml', previous: $throwable);
        }
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            \Symfony\UX\TwigComponent\Attribute\AsTwigComponent::class,
            'twig-component'
        );
    }
}
