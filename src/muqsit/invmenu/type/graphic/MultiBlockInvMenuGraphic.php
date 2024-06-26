<?php

declare(strict_types=1);

namespace muqsit\invmenu\type\graphic;

use InvalidStateException;
use muqsit\invmenu\type\graphic\network\InvMenuGraphicNetworkTranslator;
use pocketmine\inventory\Inventory;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

final class MultiBlockInvMenuGraphic implements PositionedInvMenuGraphic{

	/** @var PositionedInvMenuGraphic[] */
	private array $graphics;

	/**
	 * @param PositionedInvMenuGraphic[] $graphics
	 */
	public function __construct(array $graphics){
		$this->graphics = $graphics;
	}

	private function first() : PositionedInvMenuGraphic{
		$first = current($this->graphics);
		if($first === false){
			throw new InvalidStateException("Tried sending inventory from a multi graphic consisting of zero entries");
		}

		return $first;
	}

	public function send(Player $player, ?string $name) : void{
		foreach($this->graphics as $graphic){
			$graphic->send($player, $name);
		}
	}

	public function sendInventory(Player $player, Inventory $inventory) : bool{
		return $this->first()->sendInventory($player, $inventory);
	}

	public function remove(Player $player) : void{
		foreach($this->graphics as $graphic){
			$graphic->remove($player);
		}
	}

	public function getNetworkTranslator() : ?InvMenuGraphicNetworkTranslator{
		return $this->first()->getNetworkTranslator();
	}

	public function getPosition() : Vector3{
		return $this->first()->getPosition();
	}
}