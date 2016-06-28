<?php

namespace Wame\RouterModule\Commands;

use Nette\Mail\SmtpException,
	Symfony\Component\Console\Command\Command,
	Symfony\Component\Console\Input\InputInterface,
	Symfony\Component\Console\Output\OutputInterface,
	Wame\RouterModule\Model\DefaultRoutesRegister;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class UpdateDefaultRoutesCommand extends Command {

	/** @var DefaultRoutesRegister */
	private $defaultRoutesRegister;

	public function injectDefaultRoutesRegister(DefaultRoutesRegister $defaultRoutesRegister) {
		$this->defaultRoutesRegister = $defaultRoutesRegister;
	}

	protected function configure() {
		$this->setName('router:update-default-routes')
				->setDescription('Updates default routes table');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		
		try {
			$this->defaultRoutesRegister->updateRoutesTable();
			$output->writeLn('Default routes updated');
			return 0; // zero return code means everything is ok
		} catch (SmtpException $e) {
			$output->writeLn('<error>' . $e->getMessage() . '</error>');
			return 1; // non-zero return code means error
		}
	}

}
