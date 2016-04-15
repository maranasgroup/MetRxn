package primeR;

import java.awt.Component;
import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.math.BigInteger;
import java.util.Arrays;
import java.util.Collections;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Map.Entry;
import java.util.Set;
import java.util.SortedSet;
import java.util.TreeSet;

import com.google.common.math.BigIntegerMath;
import com.opencsv.CSVReader;

import chemaxon.calculations.clean.Clean2D;
import chemaxon.calculations.clean.Cleaner;
import chemaxon.calculations.hydrogenize.Hydrogenize;
import chemaxon.formats.MolExporter;
import chemaxon.formats.MolImporter;
import chemaxon.marvin.MolPrinter;
import chemaxon.marvin.calculations.MajorMicrospeciesPlugin;
import chemaxon.marvin.calculations.pKaPlugin;
import chemaxon.marvin.calculations.pKaPluginDisplay;
import chemaxon.marvin.plugin.CalculatorPluginDisplay;
import chemaxon.marvin.plugin.PluginException;
import chemaxon.marvin.services.MoleculeExporterArgument;
import chemaxon.marvin.uif.action.support.PropertiesUtil;
import chemaxon.naming.n2s.parse.Radical;
import chemaxon.standardizer.actions.MesomerizeAction;
import chemaxon.standardizer.actions.NeutralizeAction;
import chemaxon.struc.MPropertyContainer;
import chemaxon.struc.MolAtom;
import chemaxon.struc.MolBond;
import chemaxon.struc.Molecule;
import chemaxon.struc.MoleculeGraph;

//import chemaxon.util.settings.loader.PropertiesLoader;

/*the numbering should transfer to all, make sure that is done .. */
/* The idea is to create a graph that can be extended in the future also, 
 * Right now we focus on connectivity, 
 * as and when we need to consider other things, we can focus on them too*/
public class molProcess extends Thread {
	private static final int MM_DIST_THRESH = 40;
	private static final String PRODUCT = "product_";
	private static final String PRIME = "prime_";
	private static final double pH_0 = 0.0; // contains all protons i think
	private static final String NODEINDEXFILENAME = "nodeTypes.tsv";/* has to be made available locally */
	private static final String PRODUCT_LOOKUP = "product.lookup";
	public static final int MAXLEVEL = 4;
	public static String INDEX = "indx";
	public static String LONEPAIRCOUNT = "lp";
	public static String VALENCE = "val";
	public static String RADICALCOUNT = "rad";
	public static String ELECTRONEGATIVITY = "en";
	public static String HCOUNT = "h";
	public static String CHIRALITY = "chrl";
	public static String QUERY = "isQuery";
	public static String RING = "ring";
	public static String TERMINAL = "term";
	public static String BONDTYPE = "bnd";
	public static String PH = "ph";
	public static String HYBRIDIZATIONSTATE = "hybz";
	public static String SYMBOL = "smbl";
	public static String INDEXTYPE = "idxType"; /* original or new, true is original, false is new */
	public static String IGNOREDBYATOM = "ignr";
	public static String ETYPE = "et";
	public static SortedSet<String> sortedProducts = Collections.synchronizedSortedSet(new TreeSet<String>());

	private static MajorMicrospeciesPlugin mmSpeciesPlugin = new MajorMicrospeciesPlugin();

	private static HashMap<String, Integer> nodeIndex = loadNodeIndex();
	public static HashMap<Integer, Integer> primeHash = loadPrimes();
	public static HashMap<Integer, Integer> primeIndex = primes.getPrimeIndex(primeHash);

	public static void main(String[] args) {
		try {
			// String molStr =
			// "CCCC[C@H](NC(=O)[C@@H]1CCCN1C(=O)[C@H](CCCNC(N)=N)NC(C)=O)C(=O)N[C@@H](CCC1=CC=CC=C1)C(=O)N[C@@H](C)C(=O)N[C@@H](C)C(=O)N[C@@H](CCCCN)C(=O)NCC(=O)N1CCC[C@H]1C(=O)N[C@@H](CC(C)C)C(N)=O";
			String molStr = "N[C@@H](Cc1ccc(O)cc1)C(O)=O";
			Molecule mol = getMolObject(molStr);
			mol = getMMSpecies(mol, pH_0);
			mol = standardizeMol(mol);			
			mol = annotatedMolecule(mol, true);
			HashMap<Molecule, Double> mmDistribution = getMMDistribution(mol);
			Set<Molecule> molSet = mmDistribution.keySet();
			for (Molecule mol2 : molSet) {
				mol2 = annotatedMolecule(mol2, false);
				addPseudo(mol2, mmDistribution.get(mol2));
				new Cleaner().clean(mol2, 2);
				String out = MolExporter.exportToFormat(mol2, "mrv:S");
				System.out.println(out);
				System.out.println();
				System.out.println("*************");
			}

			mol = displayFilter(mol);

		}
		catch (IOException e) {
			e.printStackTrace();
		}
	}

	private static HashMap<Integer, Integer> loadPrimes() {
		return primes.getPrimesAsHash();
	}

	public static HashMap<String, Integer> loadNodeIndex() {
		HashMap returnVal = new HashMap<String, Integer>();
		try {
			CSVReader reader = new CSVReader(new FileReader(NODEINDEXFILENAME), '\t', '"', 1);
			String[] nextLine;
			while ((nextLine = reader.readNext()) != null) {

				returnVal.put(nextLine[0] + ":" + nextLine[1], Integer.valueOf(nextLine[2]));
			}
			reader.close();
		}
		catch (FileNotFoundException e) {
			e.printStackTrace();
		}
		catch (IOException e) {
			e.printStackTrace();
		}
		return returnVal;
	}

	private static Molecule displayFilter(Molecule mol) {
		// TODO filter the molecule for display, choose the atoms and
		Set<String> hideThese = new HashSet<String>();
		hideThese.add(BONDTYPE);
		hideThese.add(INDEX);
		hideThese.add(LONEPAIRCOUNT);
		hideThese.add(VALENCE);
		hideThese.add(RADICALCOUNT);
		hideThese.add(ELECTRONEGATIVITY);
		hideThese.add(HCOUNT);
		hideThese.add(CHIRALITY);
		hideThese.add(QUERY);
		hideThese.add(RING);
		hideThese.add(BONDTYPE);
		hideThese.add(PH);
		hideThese.add(HYBRIDIZATIONSTATE);
		hideThese.add(SYMBOL);
		hideThese.add(INDEXTYPE);
		hideThese.add(IGNOREDBYATOM);
		hideThese.add(ETYPE);
		return mol;
	}

	public static void addPseudo(Molecule mol_in, Double pH_in) {
		/*Pseudo atoms in place of lone pair electrons and Hydrogen connections.*/
		mol_in.setProperty(PH, pH_in.toString());
		MolBond[] bondArray = mol_in.getBondArray();
		Hydrogenize.convertExplicitHToImplicit(mol_in);
		
		MolAtom[] atomArray2 = mol_in.getAtomArray();
		for (int i = 0; i < atomArray2.length; i++) {
			if (atomArray2[i].getSymbol().equalsIgnoreCase("H") || atomArray2[i].getSymbol().equalsIgnoreCase("LP")) continue;
			
			atomArray2[i].putProperty(HCOUNT, atomArray2[i].getImplicitHCount(true) + atomArray2[i].getExplicitHcount());
			atomArray2[i].putProperty(LONEPAIRCOUNT, atomArray2[i].getLonePairCount());
			atomArray2[i].putProperty(VALENCE, atomArray2[i].getValence());
		}
		
		for (int i = 0; i < bondArray.length; i++) {
			/*The first two if's for .H. and LP will be removed*/
			/*create new enodes e-h based on number of protons and e-lp based on the number of lone pairs.*/
			if (bondArray[i].getProperty(SYMBOL).toString().contains(".H.") || bondArray[i].getProperty(SYMBOL).toString().contains(".LP.")) {
				continue;
			}			
			else {
				/* here the bond information of being in the ring plays a key role */
				MolAtom e_node = new MolAtom(MolAtom.PSEUDO);
				MolAtom e_node2 = new MolAtom(MolAtom.PSEUDO);
				e_node.setAliasstr("e");
				e_node2.setAliasstr("e");
				e_node.putProperty(ETYPE, "e-c");
				e_node2.putProperty(ETYPE, "e-c");
				MolBond e_bond = new MolBond(e_node, e_node2);
				Set<String> propertyKeySet = bondArray[i].propertyKeySet();
				/* properties are copied here */
				for (String p : propertyKeySet) {
					e_bond.putProperty(p, bondArray[i].getProperty(p));
				}

				MolBond bond = new MolBond(bondArray[i].getAtom1(), e_node);
				MolBond bond2 = new MolBond(bondArray[i].getAtom2(), e_node2);

				mol_in.add(e_node);
				mol_in.add(e_node2);
				mol_in.add(e_bond);
				mol_in.add(bond);
				mol_in.add(bond2);

				mol_in.removeBond(bondArray[i]);
			}

		}

		/* next we add the extra electron nodes, that would account for double and triple */
		MolAtom[] atomArray = mol_in.getAtomArray();
		int lp_count = 0;
		int h_count = 0;
		for (int i = 0; i < atomArray.length; i++) {
			lp_count = 0;
			h_count = 0;
			
			if (atomArray[i].isPseudo()) if (atomArray[i].getAliasstr().equalsIgnoreCase("e")) continue;

			if (atomArray[i].getSymbol().equalsIgnoreCase("H")) continue;
			
			h_count = (Integer)atomArray[i].getProperty(HCOUNT);
			
			for (int j = 0; j < h_count; j++) {
				MolAtom e_node = new MolAtom(MolAtom.PSEUDO);
				e_node.setAliasstr("e");
				e_node.putProperty(ETYPE, "e-h");
				MolBond e_bond = new MolBond(e_node, atomArray[i]);
				e_bond.putProperty(IGNOREDBYATOM, atomArray[i].getProperty(INDEX));
				mol_in.add(e_node);
				mol_in.add(e_bond);
			}
			
			lp_count = (Integer)atomArray[i].getProperty(LONEPAIRCOUNT);
			
			for (int j = 0; j < lp_count; j++) {
				MolAtom e_node = new MolAtom(MolAtom.PSEUDO);
				e_node.setAliasstr("e");
				e_node.putProperty(ETYPE, "e-lp");
				MolBond e_bond = new MolBond(e_node, atomArray[i]);
				e_bond.putProperty(IGNOREDBYATOM, atomArray[i].getProperty(INDEX));
				e_bond.putProperty(SYMBOL, "lp");
				mol_in.add(e_node);
				mol_in.add(e_bond);
			}
			

			int e_count = 0;
			MolBond[] bondArray2 = atomArray[i].getBondArray();
			for (int j = 0; j < bondArray2.length; j++) {
				if (bondArray2[j].containsPropertyKey(SYMBOL)) {
					if (bondArray2[j].getProperty(SYMBOL).toString().equalsIgnoreCase("lp")) continue;
				}
				if (bondArray2[j].getOtherAtom(atomArray[i]).getAliasstr().equalsIgnoreCase("e")) {
					e_count++;
				}
			}
			e_count = (int) atomArray[i].getProperty(VALENCE) - e_count;
			if (e_count < 0) {
				System.err.println("ABORTED, INCORRECT CONNECTIVITY");
				return;
			}
			for (int j = 0; j < e_count; j++) {
				MolAtom e_node = new MolAtom(MolAtom.PSEUDO);
				e_node.setAliasstr("e");
				e_node.putProperty(ETYPE, (j + 2) + "-e");

				MolBond e_bond = new MolBond(e_node, atomArray[i]);
				e_bond.putProperty(IGNOREDBYATOM, atomArray[i].getProperty(INDEX));

				mol_in.add(e_node);
				mol_in.add(e_bond);
			}
		}

		/* Now that the graph is redrawn, we need to index the e, h and bonds */
		/*
		 * 1) start with numbering the protons2) then number the lp 3) then number the electrons that are part of the
		 * connecting ones, each will have its own indexing scheme
		 */
		atomArray = mol_in.getAtomArray();
		for (int i = 0; i < atomArray.length; i++) {
			if (atomArray[i].isPseudo()) if (atomArray[i].getAliasstr().equalsIgnoreCase("e")) continue;

			if (atomArray[i].getSymbol().equalsIgnoreCase("H")) continue;

			lp_count = 0;
			h_count = 0;

			MolBond[] bondArray2 = atomArray[i].getBondArray();
			for (int j = 0; j < bondArray2.length; j++) {
				if (bondArray2[j].getOtherAtom(atomArray[i]).getProperty(ETYPE).toString().equalsIgnoreCase("e-lp")) {
					lp_count++;
					bondArray2[j].getOtherAtom(atomArray[i]).putProperty(INDEX, lp_count + "#" + atomArray[i].getProperty(INDEX).toString() + "#e-lp");
				}
				else if (bondArray2[j].getOtherAtom(atomArray[i]).getProperty(ETYPE).toString().equalsIgnoreCase("e-h")) {
					h_count++;
					MolAtom otherEatom = bondArray2[j].getOtherAtom(atomArray[i]);
					otherEatom.putProperty(INDEX, h_count + "#" + atomArray[i].getProperty(INDEX).toString() + "#e-h");					
				}
				else if (bondArray2[j].getOtherAtom(atomArray[i]).getProperty(ETYPE).toString().contains("-e")) {
					bondArray2[j].getOtherAtom(atomArray[i]).putProperty(INDEX, bondArray2[j].getOtherAtom(atomArray[i]).getProperty(ETYPE).toString() + "#" + atomArray[i].getProperty(INDEX).toString());
				}
				else if (bondArray2[j].getOtherAtom(atomArray[i]).getProperty(ETYPE).toString().contains("e-c")) {
					/* here, we partially index the -e nodes, full indexing will be done after the bonds are indexed */
					bondArray2[j].getOtherAtom(atomArray[i]).putProperty(INDEX, atomArray[i].getProperty(INDEX).toString() + "#e-c#");
				}
			}
		}
		/* now e-c nodes are mapped properly */
		atomArray = mol_in.getAtomArray();
		MolBond[] bondArray2;
		for (int i = 0; i < atomArray.length; i++) {
			if (atomArray[i].isPseudo()) {
				if (atomArray[i].containsPropertyKey(ETYPE)) {
					if (atomArray[i].getProperty(ETYPE).toString().equalsIgnoreCase("e-c")) {
						bondArray2 = atomArray[i].getBondArray();
						for (int j = 0; j < bondArray2.length; j++) {
							if (bondArray2[j].getOtherAtom(atomArray[i]).isPseudo()) {
								if (bondArray2[j].getOtherAtom(atomArray[i]).containsPropertyKey(ETYPE)) {
									if (bondArray2[j].getOtherAtom(atomArray[i]).getProperty(ETYPE).toString().equalsIgnoreCase("e-c")) {
										atomArray[i].putProperty(INDEX, atomArray[i].getProperty(INDEX).toString() + bondArray2[j].getOtherAtom(atomArray[i]).getProperty(INDEX).toString().split("[#]")[0]);
									}
								}
							}
						}
					}
				}
			}
		}

		/*
		 * TODO: check difference between NAD+ and NADH TODO: add index to bonds TODO: GI for all the molecules and dont
		 * worry about computation this time, you have all the resources in the world ... let it run forever !!
		 */
		atomArray = mol_in.getAtomArray();
		for (int i = 0; i < atomArray.length; i++) {
			if (atomArray[i].isPseudo()) if (atomArray[i].getAliasstr().equalsIgnoreCase("e")) continue;
			if (atomArray[i].getSymbol().equalsIgnoreCase("H")) continue;

			if (atomArray[i].containsPropertyKey(ELECTRONEGATIVITY)) {
				MolAtom en_node = new MolAtom(MolAtom.PSEUDO);
				en_node.setAliasstr("en");
				en_node.putProperty(INDEX, atomArray[i].getProperty(ELECTRONEGATIVITY).toString() + "#" + atomArray[i].getProperty(INDEX).toString());
				MolBond en_bond = new MolBond(atomArray[i], en_node);
				en_bond.putProperty(IGNOREDBYATOM, atomArray[i].getProperty(INDEX));
				mol_in.add(en_node);
				mol_in.add(en_bond);
			}
			if (atomArray[i].containsPropertyKey(RADICALCOUNT)) {
				if ((int) atomArray[i].getProperty(RADICALCOUNT) == 1) {
					MolAtom rad_node = new MolAtom(MolAtom.PSEUDO);
					rad_node.setAliasstr("rad");
					rad_node.putProperty(INDEX, "rad#" + atomArray[i].getProperty(INDEX).toString());
					MolBond rad_bond = new MolBond(atomArray[i], rad_node);
					rad_bond.putProperty(IGNOREDBYATOM, atomArray[i].getProperty(INDEX));
					mol_in.add(rad_node);
					mol_in.add(rad_bond);
				}
			}
			if (atomArray[i].containsPropertyKey(CHIRALITY)) {
				if ((int) atomArray[i].getProperty(CHIRALITY) > 0) {
					MolAtom chrl_node = new MolAtom(MolAtom.PSEUDO);
					chrl_node.setAliasstr("chrl");
					chrl_node.putProperty(INDEX, atomArray[i].getProperty(CHIRALITY).toString() + "#" + atomArray[i].getProperty(INDEX).toString());
					MolBond chrl_bond = new MolBond(atomArray[i], chrl_node);
					chrl_bond.putProperty(IGNOREDBYATOM, atomArray[i].getProperty(INDEX));
					mol_in.add(chrl_node);
					mol_in.add(chrl_bond);
				}
			}
			if (atomArray[i].containsPropertyKey(HYBRIDIZATIONSTATE)) {
				MolAtom hbz_node = new MolAtom(MolAtom.PSEUDO);
				hbz_node.setAliasstr("hbz");
				hbz_node.putProperty(INDEX, atomArray[i].getProperty(HYBRIDIZATIONSTATE).toString() + "#" + atomArray[i].getProperty(INDEX).toString());
				MolBond hbz_bond = new MolBond(atomArray[i], hbz_node);
				hbz_bond.putProperty(IGNOREDBYATOM, atomArray[i].getProperty(INDEX));
				mol_in.add(hbz_node);
				mol_in.add(hbz_bond);
			}
			if (atomArray[i].containsPropertyKey(RING)) {
				if ((boolean) atomArray[i].getProperty(RING) == true) {
					MolAtom rng_node = new MolAtom(MolAtom.PSEUDO);
					rng_node.setAliasstr("rng");
					rng_node.putProperty(INDEX, "rng#" + atomArray[i].getProperty(INDEX).toString());
					MolBond rng_bond = new MolBond(atomArray[i], rng_node);
					rng_bond.putProperty(IGNOREDBYATOM, atomArray[i].getProperty(INDEX));
					mol_in.add(rng_node);
					mol_in.add(rng_bond);
				}
			}
		}
		MolBond[] bondArray3 = mol_in.getBondArray();
		for (int j = 0; j < bondArray3.length; j++) {
			if (bondArray3[j].containsPropertyKey(RING)) {
				if ((boolean) bondArray3[j].getProperty(RING) == true) {
					MolAtom rng_node = new MolAtom(MolAtom.PSEUDO);
					MolAtom rng_node2 = new MolAtom(MolAtom.PSEUDO);
					rng_node.setAliasstr("erng");
					rng_node2.setAliasstr("erng");
					rng_node.putProperty(INDEX, "erng#" + bondArray3[j].getAtom1().getProperty(INDEX).toString());
					rng_node2.putProperty(INDEX, "erng#" + bondArray3[j].getAtom2().getProperty(INDEX).toString());

					MolBond rng_bond = new MolBond(bondArray3[j].getAtom1(), rng_node);
					rng_bond.putProperty(IGNOREDBYATOM, bondArray3[j].getAtom1().getProperty(INDEX));
					MolBond rng_bond2 = new MolBond(bondArray3[j].getAtom2(), rng_node2);
					rng_bond2.putProperty(IGNOREDBYATOM, bondArray3[j].getAtom2().getProperty(INDEX));

					mol_in.add(rng_node);
					mol_in.add(rng_node2);
					mol_in.add(rng_bond);
					mol_in.add(rng_bond2);
				}
			}
		}
	}

	public static HashMap<Molecule, Double> getMMDistribution(Molecule mol) {
		/*This function returns a HashMap with microspecies molecule as key, and the corresponding PH as the value*/
		HashMap<Molecule, Double> returnVal = new HashMap<Molecule, Double>();
		try {
			pKaPlugin pKAplugin = new pKaPlugin();
			pKAplugin.setMolecule(mol);
			pKAplugin.setKeepExplicitHydrogens(true);
			pKAplugin.setMsCalc(true);
			pKAplugin.standardize(mol);

			/* everything below is the same as default */
			pKAplugin.setConsiderTautomerization(false);
			pKAplugin.setpHStep(1);
			pKAplugin.setMicropKaCalc(false);
			pKAplugin.setTemperature(298.00);
			pKAplugin.setpHUpper(14.0);
			pKAplugin.setpHLower(0.0);
			pKAplugin.run();
			double[] pHs = pKAplugin.getpHs(); // pH values
			int mscount = pKAplugin.getMsCount();
			int bestPhIndex;
			for (int i = 0; i < mscount; ++i) {
				bestPhIndex = getBestPhIndex(pKAplugin.getMsDistribution(i));
				if (bestPhIndex >= 0) {
					returnVal.put(pKAplugin.getMsMolecule(i), pHs[bestPhIndex]);
				}
			}
			return returnVal;
		}
		catch (PluginException e) {
			e.printStackTrace();
		}
		return null;
	}

	public static HashMap<Molecule, Double> getMMDistribution_2(Molecule mol) {
		HashMap<Molecule, Double> returnVal = new HashMap<Molecule, Double>();

		try {
			for (int i = 0; i <= 14; i++) {
				mmSpeciesPlugin.setMolecule(mol);
				mmSpeciesPlugin.setpH(i);
				mmSpeciesPlugin.setTakeMajorTatomericForm(false);
				mmSpeciesPlugin.run();
				Object[] keySet = returnVal.keySet().toArray();
				if (keySet.length > 1) {
					for (int j = 0; j < keySet.length; j++) {
						if (!((MoleculeGraph) keySet[j]).isSimilarTo(mmSpeciesPlugin.getMajorMicrospecies())) {
							returnVal.put(mmSpeciesPlugin.getMajorMicrospecies(), Double.valueOf(i));
						}
					}
				}
				else {
					returnVal.put(mmSpeciesPlugin.getMajorMicrospecies(), Double.valueOf(i));
				}
			}
			return returnVal;
		}
		catch (PluginException e) {
			e.printStackTrace();
			System.err.println("*******");
			System.err.println("error in getMMSpecies(mol,pH)");
			System.err.println("*******");
		}
		return null;
	}

	public static HashMap<Molecule, Double> getMMDistribution_3(Molecule mol) {
		HashMap<Molecule, Double> returnVal = new HashMap<Molecule, Double>();
		pKaPlugin pKAplugin = new pKaPlugin();
		try {
			pKAplugin.setMolecule(mol);
			Double upper = 14.0;
			Double lower = 0.0;
			pKAplugin.setpHUpper(upper);
			pKAplugin.setpHLower(lower);
			pKAplugin.run();
			double[] pHs = pKAplugin.getpHs(); // pH values
			System.out.println(Arrays.toString(pHs));
			int mscount = pKAplugin.getMsCount();
			System.out.println("msCount =" + mscount);
			int bestPhIndex;
			/*
			 * double[][] msDistributions = pKAplugin.getMsDistributions(); for (int i = 0; i < msDistributions.length;
			 * i++) { System.out.println(Arrays.toString(msDistributions[i])); }
			 */
			/*
			 * CalculatorPluginDisplay display = new pKaPluginDisplay(); display.setPlugin(pKAplugin); display.store();
			 * Component component = display.getResultComponent(); component.setVisible(true);
			 */

			for (int i = 0; i < mscount; ++i) {
				System.out.println("singleMS = " + pKAplugin.getSingleMsDistribution(i));
				System.out.println(pKAplugin.getResultAsString("msdistr", i, pKAplugin.getMsDistributions()));
				bestPhIndex = getBestPhIndex(pKAplugin.getMsDistribution(i));
				if (bestPhIndex >= 0) {
					returnVal.put(pKAplugin.getMsMolecule(i), pHs[bestPhIndex]);
				}
			}
			return returnVal;
		}
		catch (PluginException e) {
			e.printStackTrace();
		}
		return null;
	}

	private static int getBestPhIndex(double[] msDistribution) {

		double distribution = 0.0;
		int returnval = -1;
		for (int i = 0; i < msDistribution.length; i++) {
			if (msDistribution[i] > distribution) {
				distribution = msDistribution[i];
				returnval = i;/* index of that ph, where this molecule has the highest distribution */
			}
		}
		if (distribution < MM_DIST_THRESH) {
			returnval = -1;
		}
		return returnval;
	}

	private static Molecule getMMSpecies(Molecule mol, double pH) {
		try {
			mmSpeciesPlugin.setMolecule(mol);
			mmSpeciesPlugin.setpH(pH);
			mmSpeciesPlugin.run();
			return mmSpeciesPlugin.getMajorMicrospecies();
		}
		catch (PluginException e) {
			e.printStackTrace();
			System.err.println("*******");
			System.err.println("error in getMMSpecies(mol,pH)");
			System.err.println("*******");
		}
		return null;
	}

	public static Molecule getMolObject(String molStr) {
		try {
			return MolImporter.importMol(molStr);
		}
		catch (Exception e) {
			e.printStackTrace();
			System.err.println("*******");
			System.err.println(molStr);
			System.err.println("*******");
		}
		return null;
	}

	public static Molecule standardizeMol(Molecule mol) {
		try {
			mol.dearomatize();

			Hydrogenize.convertExplicitHToImplicit(mol);

			mol.dearomatize();
			mol.stereoClean();

			Cleaner.clean(mol, 2);

			mol.calcHybridization();
			return mol;
		}
		catch (Exception e) {
			e.printStackTrace();
			System.err.println("*******");
			System.err.println("standardizer error");
			System.err.println("*******");
		}
		return null;
	}

	public static Molecule annotatedMolecule(Molecule mol, boolean newIndex) {
		/*
		 * only atoms will be indexed, indexing of bonds will be done in the addPseudo(), since there will be changes in
		 * charges and protonation at different pH
		 */
		
		Hydrogenize.convertExplicitHToImplicit(mol);
		

		try {
			MolAtom[] atomArray = mol.getAtomArray();
			for (int i = 0; i < atomArray.length; i++) {
				atomArray[i].setSelected(true);

				if (atomArray[i].getSymbol().equalsIgnoreCase("LP") || atomArray[i].getSymbol().equalsIgnoreCase("H")) {
					/*capture error into a file*/
					continue;
				}
				if (newIndex) {
					atomArray[i].putProperty(INDEX, String.valueOf(i + 1));
				}

				atomArray[i].putProperty(RADICALCOUNT, atomArray[i].getRadicalCount());
				atomArray[i].putProperty(VALENCE, atomArray[i].getValence());
				atomArray[i].putProperty(LONEPAIRCOUNT, atomArray[i].getLonePairCount());
				atomArray[i].putProperty(ELECTRONEGATIVITY, atomArray[i].getRelativeNegativity());
				atomArray[i].putProperty(CHIRALITY, mol.getChirality(i));
				atomArray[i].putProperty(HYBRIDIZATIONSTATE, atomArray[i].getHybridizationState());
				atomArray[i].putProperty(RING, mol.isAtomInRing(atomArray[i]));
				atomArray[i].putProperty(TERMINAL, atomArray[i].isTerminalAtom());
				
				/*here we count the number of protons*/
				atomArray[i].putProperty(HCOUNT, atomArray[i].getImplicitHCount(true) + atomArray[i].getExplicitHcount());
				
			}
		}
		catch (Exception e) {
			e.printStackTrace();
			System.err.println("*******");
			System.err.println("Error in annotation: Atoms");
			System.err.println("*******");
			return null;
		}
		try {
			/* everything is a single bond, properties are periferal nodes */
			MolBond[] bondArray = mol.getBondArray();
			String bondSymbol;
			for (int i = 0; i < bondArray.length; i++) {
				bondSymbol = getBondSymbol(bondArray[i]);
				bondArray[i].putProperty(SYMBOL, bondSymbol);
				bondArray[i].putProperty(RING, mol.isRingBond(i));
				bondArray[i].putProperty(BONDTYPE, bondArray[i].getType());
			}
		}
		catch (Exception e) {
			e.printStackTrace();
			System.err.println("*******");
			System.err.println("Error in annotation: Bonds");
			System.err.println("*******");
			return null;
		}

		return mol;
	}

	private static String getBondSymbol(MolBond bond) {
		/*this function sorts and concatenates the atom symbols to create unique bond symbols.*/
		if (bond.getAtom1().getSymbol().compareToIgnoreCase(bond.getAtom2().getSymbol()) > 1) {
			return "." + bond.getAtom1().getSymbol() + "." + bond.getAtom2().getSymbol() + ".";
		}
		else {
			return "." + bond.getAtom2().getSymbol() + "." + bond.getAtom1().getSymbol() + ".";
		}
	}

	public static TreeSet<String> captureProperties(Molecule mol2, TreeSet<String> uniqueProperties) {
		uniqueProperties.add("b:1");
		MolAtom[] atomArray = mol2.getAtomArray();
		for (MolAtom molAtom : atomArray) {
			if (molAtom.isPseudo()) {
				if (molAtom.getAliasstr().equalsIgnoreCase("e")) {
					uniqueProperties.add(molAtom.getProperty(ETYPE).toString());
				}
				else if (molAtom.getAliasstr().equalsIgnoreCase("rng") || molAtom.getAliasstr().equalsIgnoreCase("erng") || molAtom.getAliasstr().equalsIgnoreCase("rad")) {
					uniqueProperties.add(molAtom.getAliasstr());
				}
				else if (molAtom.getAliasstr().equalsIgnoreCase("en") || molAtom.getAliasstr().equalsIgnoreCase("chrl") || molAtom.getAliasstr().equalsIgnoreCase("hbz")) {
					uniqueProperties.add(molAtom.getAliasstr() + ":" + molAtom.getProperty(INDEX).toString().split("[#]")[0]);
				}
			}
			else {
				uniqueProperties.add("a:" + molAtom.getAtno() + ":" + molAtom.getSymbol());
			}
		}
		return uniqueProperties;
	}

	public static String getProperties(MolAtom molAtom) {

		if (molAtom.isPseudo()) {
			if (molAtom.getAliasstr().equalsIgnoreCase("e")) {
				return "e:" + molAtom.getProperty(ETYPE).toString();
			}
			else if (molAtom.getAliasstr().equalsIgnoreCase("rng") || molAtom.getAliasstr().equalsIgnoreCase("erng") || molAtom.getAliasstr().equalsIgnoreCase("rad")) {
				return molAtom.getAliasstr() + ":" + molAtom.getAliasstr();
			}
			else if (molAtom.getAliasstr().equalsIgnoreCase("en") || molAtom.getAliasstr().equalsIgnoreCase("chrl") || molAtom.getAliasstr().equalsIgnoreCase("hbz")) {
				return molAtom.getAliasstr() + ":" + molAtom.getProperty(INDEX).toString().split("[#]")[0];
			}
		}
		else {
			return "a:" + molAtom.getAtno();
		}
		return null;
	}

	public static Integer getZeroIndex(String prop) {
		if (nodeIndex.containsKey(prop)) {
			return nodeIndex.get(prop);
		}
		else
			return 1;

	}

	public static void addPrimeZero(Molecule mol2) {
		int level = 0;
		MolAtom[] atomArray = mol2.getAtomArray();
		for (MolAtom molAtom : atomArray) {
			molAtom.putProperty(PRIME + level, primeHash.get(getZeroIndex(getProperties(molAtom))));
		}
		MolBond[] bondArray = mol2.getBondArray();
		for (MolBond molBond : bondArray) {
			molBond.putProperty(PRIME + level, primeHash.get(getZeroIndex("b:b")));
		}
	}

	public static void calcProduct(Molecule mol2, int level) {
		MolAtom[] atomArray = mol2.getAtomArray();
		String index;
		MolBond[] bondArray;
		BigInteger product = BigInteger.valueOf(1);
		for (MolAtom molAtom : atomArray) {
			index = molAtom.getProperty(INDEX).toString();
			bondArray = molAtom.getBondArray();
			product = BigInteger.valueOf(Long.valueOf(molAtom.getProperty(PRIME + level).toString()));
			for (int i = 0; i < bondArray.length; i++) {

				if (bondArray[i].containsPropertyKey(IGNOREDBYATOM)) if (bondArray[i].getProperty(IGNOREDBYATOM).toString().equalsIgnoreCase(index)) continue;

				product = BigInteger.valueOf(Long.valueOf(bondArray[i].getProperty(PRIME + level).toString())).multiply(product);
			}
			molAtom.putProperty(PRODUCT + level, product.toString());
			if (molAtom.isPseudo()) {
				sortedProducts.add("e:" + product.toString() + ":" + level);
			}
			else {
				sortedProducts.add("a:" + product.toString() + ":" + level);
			}
		}

		bondArray = mol2.getBondArray();
		for (MolBond molBond : bondArray) {
			product = BigInteger.valueOf(Long.valueOf(molBond.getProperty(PRIME + level).toString()));
			product = BigInteger.valueOf(Long.valueOf(molBond.getAtom1().getProperty(PRIME + level).toString())).multiply(product);
			product = BigInteger.valueOf(Long.valueOf(molBond.getAtom2().getProperty(PRIME + level).toString())).multiply(product);
			molBond.putProperty(PRODUCT + level, product.toString());
			sortedProducts.add("b:" + product.toString() + ":" + level);
		}
	}

	public static HashMap<Integer, HashMap<String, Integer>> updatedLookup() {
		HashMap<Integer, HashMap<String, Integer>> returnVal = new HashMap<Integer, HashMap<String, Integer>>();
		HashMap<Integer, Integer> maxValue = new HashMap<Integer, Integer>();
		for (int i = 0; i <= MAXLEVEL; i++) {
			if (!returnVal.containsKey(i)) {
				returnVal.put(i, new HashMap<String, Integer>());
				maxValue.put(i, 0);
			}
		}
		/* outer index is the level */
		try {
			BufferedReader inputStream = new BufferedReader(new FileReader(PRODUCT_LOOKUP));
			String inLine;
			String[] split;
			int level;
			int prime;
			while ((inLine = inputStream.readLine()) != null) {
				split = inLine.split("\t");
				level = Integer.valueOf(split[0].split("[:]")[2]);
				prime = Integer.valueOf(split[1]);
				returnVal.get(level).put(split[0], prime);
				if (prime > maxValue.get(level)) {
					maxValue.put(level, prime);
				}
			}
			for (String prod : molProcess.sortedProducts) {
				level = Integer.valueOf(prod.split("[:]")[2]);
				if (!returnVal.get(level).containsKey(prod)) {
					prime = primeHash.get(primeIndex.get(maxValue.get(level)) + 1);
					returnVal.get(level).put(prod, prime);
					if (prime > maxValue.get(level)) {
						maxValue.put(level, prime);
					}
				}
			}
			inputStream.close();
		}
		catch (IOException e) {
			System.err.println("IOException:");
			e.printStackTrace();
		}
		return returnVal;

	}

	public static void updatePrimes(Molecule p_mol, int i) {
		// TODO Auto-generated method stub

	}
}

/* read molecules from tab file */
/* convert smiles to mol objects */
/* standardize the mol objects -> clean in 2d, aromatic to kekule, cis and trans when ?, R and S when ? */
/* use isRingBond, isConjugated, isCoordinate, also */
/* number them and print them w/o proton or charge ?? */
/* print them */
/*
 * find the pseudoisomer distribution, number them and print them in a way such that it is possible to recreate the
 * molecule
 */
