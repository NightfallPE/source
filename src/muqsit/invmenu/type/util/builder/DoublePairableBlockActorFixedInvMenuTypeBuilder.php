<?php

declare(strict_types=1);

namespace muqsit\invmenu\type\util\builder;

use InvalidStateException;
use muqsit\invmenu\type\DoublePairableBlockActorFixedInvMenuType;
use muqsit\invmenu\type\graphic\network\BlockInvMenuGraphicNetworkTranslator;

final class DoublePairableBlockActorFixedInvMenuTypeBuilder implements InvMenuTypeBuilder{
	use BlockInvMenuTypeBuilderTrait;
	use FixedInvMenuTypeBuilderTrait;
	use GraphicNetworkTranslatableInvMenuTypeBuilderTrait;

	private ?string $block_actor_id = null;

	public function __construct(){
		$this->addGraphicNetworkTranslator(BlockInvMenuGraphicNetworkTranslator::instance());
	}

	public function setBlockActorId(string $block_actor_id) : self{
		$this->block_actor_id = $block_actor_id;
		return $this;
	}

	private function getBlockActorId() : string{
		if($this->block_actor_id === null){
			throw new InvalidStateException("No block actor ID was specified");
		}

		return $this->block_actor_id;
	}

	public function build() : DoublePairableBlockActorFixedInvMenuType{
		return new DoublePairableBlockActorFixedInvMenuType($this->getBlock(), $this->getSize(), $this->getBlockActorId(), $this->getGraphicNetworkTranslator());
	}
}